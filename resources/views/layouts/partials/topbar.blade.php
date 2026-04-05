@php
    $unreadNotifications = auth()->user()->unreadNotifications()->limit(5)->get();
    $unreadCount = auth()->user()->unreadNotifications()->count();
@endphp

<div class="d-flex justify-content-end align-items-center mb-3 bg-white p-2 rounded shadow-sm">

    <!-- Global Search -->
    <div class="position-relative me-3" style="min-width: 320px;">
        <div class="input-group">
            <span class="input-group-text bg-light border-0">
                <i class="bi bi-search"></i>
            </span>
            <input type="text" id="globalSearch" class="form-control border-0 bg-light"
                   placeholder="ค้นหา... (Ctrl+K)" autocomplete="off"
                   aria-label="Global search">
            <span class="input-group-text bg-light border-0" id="searchShortcutHint"
                  style="font-size: 0.7rem; color: #6c757d; cursor: pointer;"
                  title="Press Ctrl+K or / to focus">
                <kbd class="d-none d-md-inline">Ctrl+K</kbd>
            </span>
        </div>
        <div id="searchResults" class="position-absolute w-100 bg-white shadow rounded mt-1"
             style="z-index: 1050; max-height: 500px; overflow-y: auto; display: none; min-width: 400px;">
        </div>
    </div>

    <!-- Notification Bell -->
    <div class="dropdown me-3">
        <button class="btn btn-light position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 1.25rem;">
            <i class="bi bi-bell"></i>
            @if($unreadCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="font-size: 0.65rem;">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationDropdown" style="width: 380px; max-height: 480px; overflow-y: auto;">
            <li class="dropdown-header d-flex justify-content-between align-items-center">
                <strong>การแจ้งเตือน</strong>
                @if($unreadCount > 0)
                    <span class="badge bg-danger">{{ $unreadCount }} รายการยังไม่อ่าน</span>
                @else
                    <span class="badge bg-secondary">ไม่มีรายการใหม่</span>
                @endif
            </li>
            <li><hr class="dropdown-divider"></li>

            @forelse($unreadNotifications as $notification)
                <li>
                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 {{ $notification->read_at ? 'text-muted' : '' }}" style="{{ $notification->read_at ? '' : 'background-color: #f0f7ff; border-left: 3px solid ' . ($notification->data['color'] ?? '#0d6efd') . ';' }}">
                            <div class="d-flex align-items-start">
                                <div class="me-2">
                                    <i class="{{ $notification->data['icon'] ?? 'bi-bell' }} text-{{ $notification->data['color'] ?? 'primary' }}" style="font-size: 1.1rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold text-{{ $notification->data['color'] ?? 'primary' }}">{{ $notification->data['title'] ?? 'การแจ้งเตือน' }}</div>
                                    <small class="text-muted d-block">{{ Str::limit($notification->data['message'] ?? '', 80) }}</small>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </button>
                    </form>
                </li>
                <li><hr class="dropdown-divider m-0"></li>
            @empty
                <li>
                    <div class="dropdown-item text-center text-muted py-4">
                        <i class="bi bi-bell-slash" style="font-size: 2rem;"></i>
                        <div class="mt-2">ไม่มีการแจ้งเตือน</div>
                    </div>
                </li>
            @endforelse

            <li><hr class="dropdown-divider"></li>
            <li>
                <div class="dropdown-item d-flex justify-content-between align-items-center py-2">
                    <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-bell me-1"></i> ดูการแจ้งเตือนทั้งหมด
                    </a>
                    @if($unreadCount > 0)
                        <form action="{{ route('notifications.read-all') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-check-all me-1"></i> อ่านทั้งหมด
                            </button>
                        </form>
                    @endif
                </div>
            </li>
        </ul>
    </div>

    <!-- User Info -->
    <span class="me-2">
        ผู้ใช้งาน: <strong>{{ auth()->user()->name }}</strong>
        <span class="badge bg-primary ms-1">{{ strtoupper(auth()->user()->role) }}</span>
    </span>
</div>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Global Search Script -->
<script>
(function() {
    const searchInput = document.getElementById('globalSearch');
    const searchResults = document.getElementById('searchResults');
    let debounceTimer = null;
    let currentXhr = null;

    if (!searchInput || !searchResults) return;

    // Icon mapping for Bootstrap Icons
    const groupConfig = {
        employees:     { label: 'พนักงาน',     icon: 'bi-person-badge',  color: 'primary' },
        items:         { label: 'สินค้า',        icon: 'bi-box-seam',      color: 'success' },
        requisitions:  { label: 'ใบเบิก',        icon: 'bi-file-earmark-text', color: 'warning' },
        departments:   { label: 'แผนก',          icon: 'bi-building',      color: 'info' },
        positions:     { label: 'ตำแหน่ง',       icon: 'bi-briefcase',     color: 'secondary' },
    };

    function performSearch(query) {
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        if (currentXhr) {
            currentXhr.abort();
        }

        currentXhr = new XMLHttpRequest();
        currentXhr.onreadystatechange = function() {
            if (currentXhr.readyState === 4) {
                currentXhr = null;
                if (this.status === 200) {
                    renderResults(JSON.parse(this.responseText));
                }
            }
        };
        currentXhr.open('GET', '{{ route('search') }}?q=' + encodeURIComponent(query), true);
        currentXhr.send();
    }

    function renderResults(data) {
        let html = '';
        let hasResults = false;

        for (const [type, config] of Object.entries(groupConfig)) {
            const results = data[type] || [];
            if (results.length === 0) continue;
            hasResults = true;

            html += '<div class="px-3 py-2 bg-light border-bottom"><small class="text-muted fw-bold">' +
                    '<i class="bi ' + config.icon + ' me-1"></i>' + config.label +
                    ' <span class="badge bg-secondary">' + results.length + '</span></small></div>';

            results.forEach(function(item) {
                html += '<a href="' + item.route + '" class="dropdown-item d-flex align-items-start py-2 px-3 search-result-item">' +
                        '<div class="me-2"><i class="bi ' + item.icon + ' text-' + item.color + '"></i></div>' +
                        '<div class="flex-grow-1">' +
                        '<div class="fw-bold">' + escapeHtml(item.title) + '</div>' +
                        '<small class="text-muted">' + escapeHtml(item.subtitle) + '</small>' +
                        '</div></a>';
            });
        }

        if (!hasResults) {
            html = '<div class="px-3 py-4 text-center text-muted">' +
                   '<i class="bi bi-search" style="font-size: 1.5rem;"></i>' +
                   '<div class="mt-1">ไม่พบผลลัพธ์</div></div>';
        }

        searchResults.innerHTML = html;
        searchResults.style.display = 'block';
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Debounced input handler
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();
        debounceTimer = setTimeout(function() {
            performSearch(query);
        }, 300);
    });

    // Show results on focus if there's a query
    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 2) {
            performSearch(this.value.trim());
        }
    });

    // Hide results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchResults.contains(e.target) && e.target !== searchInput) {
            searchResults.style.display = 'none';
        }
    });

    // Keyboard shortcut: Ctrl+K or / to focus
    document.addEventListener('keydown', function(e) {
        // Ctrl+K or Cmd+K
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        }
        // "/" to focus (only when not in an input)
        if (e.key === '/' && !['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
            e.preventDefault();
            searchInput.focus();
        }
        // Escape to blur
        if (e.key === 'Escape' && document.activeElement === searchInput) {
            searchInput.blur();
            searchResults.style.display = 'none';
        }
    });
})();
</script>
