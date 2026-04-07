@php
    // Cache unread count for 30 seconds to avoid querying on every page load
    $userId = auth()->id();
    $cacheKey = "unread_count_{$userId}";
    $unreadCount = cache()->remember($cacheKey, 30, function () use ($userId) {
        $user = \App\Models\User::find($userId);
        return $user ? $user->unreadNotifications()->count() : 0;
    });

    // Only fetch recent notifications if needed for dropdown
    $recentUnread = null;
    if ($unreadCount > 0) {
        $recentUnread = cache()->remember("recent_notifications_{$userId}", 30, function () use ($userId) {
            $user = \App\Models\User::find($userId);
            return $user ? $user->unreadNotifications()->limit(5)->get() : collect();
        });
    }
@endphp

<div class="d-flex align-items-center px-4 mb-3"
     style="height: 58px; background: var(--topbar-bg); border-bottom: 1px solid var(--topbar-border); gap: 12px;">

    {{-- Global Search --}}
    <div class="position-relative" style="flex: 1; max-width: 380px;">
        <div class="d-flex align-items-center px-3 gap-2"
             style="height: 36px; background: var(--input-bg); border: 1px solid var(--input-border);
                    border-radius: 10px; transition: border-color 0.15s;"
             id="searchContainer">
            <i class="fas fa-search" style="color: var(--text-muted); font-size: 13px; flex-shrink: 0;"></i>
            <input type="text" id="globalSearch"
                   class="border-0 bg-transparent flex-grow-1"
                   placeholder="ค้นหา... (Ctrl+K)"
                   autocomplete="off" aria-label="Global search"
                   style="outline: none; color: var(--text-primary); font-size: 13px; font-family: inherit;">
            <kbd style="font-size: 10px; padding: 2px 7px; border-radius: 5px;
                        border: 1px solid var(--input-border); color: var(--text-muted);
                        background: none; white-space: nowrap; display: none;" class="d-md-inline" id="searchKbd">
                Ctrl+K
            </kbd>
        </div>

        <div id="searchResults"
             class="position-absolute w-100 shadow rounded-3 mt-1"
             style="z-index: 1050; max-height: 480px; overflow-y: auto; display: none; min-width: 380px;
                    background: var(--dropdown-bg); border: 1px solid var(--border);">
        </div>
    </div>

    <div style="flex: 1;"></div>

    {{-- ── Theme Toggle Button ── --}}
    <button class="theme-toggle-btn" data-theme-toggle onclick="toggleTheme()" title="สลับ Dark Mode" aria-label="Toggle theme">
        <i class="fas fa-moon"></i>
    </button>

    {{-- Notification Bell --}}
    <div class="dropdown" style="z-index: 1060;">
        <button class="d-flex align-items-center justify-content-center position-relative border-0"
                type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                style="width: 36px; height: 36px; border-radius: 10px; background: var(--input-bg);
                       border: 1px solid var(--input-border);
                       color: var(--text-secondary); cursor: pointer; transition: all 0.15s;
                       pointer-events: auto; z-index: 1060;"
                onclick="event.stopPropagation();">
            <i class="fas fa-bell" style="font-size: 15px; pointer-events: none;"></i>
            @if($unreadCount > 0)
                <span class="position-absolute bg-danger rounded-circle border"
                      style="width: 8px; height: 8px; top: 6px; right: 6px;
                             border-color: var(--topbar-bg) !important; border-width: 1.5px !important;
                             pointer-events: none;"></span>
            @endif
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow-lg"
            aria-labelledby="notificationDropdown"
            style="width: 360px; max-height: 460px; overflow-y: auto;
                   background: var(--dropdown-bg);
                   border: 1px solid var(--border); border-radius: 12px; padding: 4px;
                   z-index: 1060;">

            <li class="d-flex justify-content-between align-items-center px-3 py-2">
                <span style="font-size: 13px; font-weight: 600; color: var(--text-primary);">การแจ้งเตือน</span>
                @if($unreadCount > 0)
                    <span style="font-size: 11px; padding: 2px 8px; border-radius: 10px;
                                 background: rgba(239,68,68,0.15); color: #f87171; font-weight: 600;">
                        {{ $unreadCount }} ยังไม่อ่าน
                    </span>
                @else
                    <span style="font-size: 11px; padding: 2px 8px; border-radius: 10px;
                                 background: var(--input-bg); color: var(--text-muted);">
                        ไม่มีรายการใหม่
                    </span>
                @endif
            </li>
            <li><hr class="dropdown-divider" style="border-color: var(--border); margin: 2px 0;"></li>

            @forelse($recentUnread ?? collect() as $notification)
                @php
                    // แปลง URL สำหรับ notification (ทุกคนเข้าได้)
                    $displayUrl = $notification->data['action_url'] ?? route('notifications.index');
                    
                    // แปลง /approve เป็นหน้า show
                    $displayUrl = str_replace('/approve', '', $displayUrl);
                    
                    // แปลง inventory borrowing URL เป็น employee borrowing URL
                    if (auth()->user()->role === 'employee') {
                        $displayUrl = str_replace('/inventory/borrowing/', '/employee/borrowings/', $displayUrl);
                    }
                @endphp
                <li>
                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="redirect_url" value="{{ $displayUrl }}">
                        <button type="submit"
                                class="dropdown-item py-2 px-3 rounded-2"
                                style="{{ $notification->read_at ? 'opacity: 0.5;' : 'background: rgba(99,102,241,0.08); border-left: 2px solid ' . ($notification->data['color'] ?? '#6366f1') . ';' }} color: var(--text-secondary);">
                            <div class="d-flex align-items-start gap-2">
                                <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }}"
                                   style="font-size: 14px; color: {{ $notification->data['color'] ?? '#818cf8' }}; margin-top: 2px; flex-shrink: 0;"></i>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-size: 12px; font-weight: 600; color: var(--text-primary); margin-bottom: 2px;">
                                        {{ $notification->data['title'] ?? 'การแจ้งเตือน' }}
                                    </div>
                                    <div style="font-size: 11px; color: var(--text-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ Str::limit($notification->data['message'] ?? '', 80) }}
                                    </div>
                                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </button>
                    </form>
                </li>
                <li><hr class="dropdown-divider" style="border-color: var(--border); margin: 2px 0;"></li>
            @empty
                <li>
                    <div class="text-center py-4" style="color: var(--text-muted);">
                        <i class="fas fa-bell-slash" style="font-size: 28px; display: block; margin-bottom: 8px;"></i>
                        <span style="font-size: 13px;">ไม่มีการแจ้งเตือน</span>
                    </div>
                </li>
            @endforelse

            <li><hr class="dropdown-divider" style="border-color: var(--border); margin: 2px 0;"></li>
            <li>
                <div class="d-flex justify-content-between align-items-center px-3 py-2 gap-2">
                    <a href="{{ route('notifications.index') }}"
                       class="erp-btn-secondary"
                       style="font-size: 12px;">
                        <i class="fas fa-bell me-1"></i> ดูทั้งหมด
                    </a>
                    @if($unreadCount > 0)
                        <form action="{{ route('notifications.read-all') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="erp-btn-secondary"
                                    style="font-size: 12px;">
                                <i class="fas fa-check-double me-1"></i> อ่านทั้งหมด
                            </button>
                        </form>
                    @endif
                </div>
            </li>
        </ul>
    </div>

    {{-- Divider --}}
    <div style="width: 1px; height: 24px; background: var(--border);"></div>

    {{-- User Info --}}
    <div class="d-flex align-items-center gap-2" style="cursor: default;">
        @if(auth()->user()->employee && auth()->user()->employee->profile_image)
            <div class="d-flex align-items-center justify-content-center rounded-circle"
                 style="width: 32px; height: 32px; overflow: hidden; flex-shrink: 0; border: 2px solid var(--accent);">
                <img src="{{ asset('storage/' . auth()->user()->employee->profile_image) }}" 
                     style="width: 100%; height: 100%; object-fit: cover;"
                     onerror="this.style.display='none'; this.parentElement.innerHTML='{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}'; this.parentElement.style.background='linear-gradient(135deg, #06b6d4, #3b82f6)'; this.parentElement.style.color='white'; this.parentElement.style.fontSize='12px';">
            </div>
        @else
            <div class="d-flex align-items-center justify-content-center rounded-circle fw-semibold"
                 style="width: 32px; height: 32px; background: linear-gradient(135deg, #06b6d4, #3b82f6);
                        color: white; font-size: 12px; flex-shrink: 0;">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
        @endif
        <div class="d-none d-md-block">
            <div style="font-size: 13px; font-weight: 500; color: var(--text-primary); line-height: 1.2;">
                {{ auth()->user()->name }}
            </div>
            <div style="font-size: 10px; color: var(--text-muted); line-height: 1.2;">
                {{ auth()->user()->employee ? auth()->user()->employee->employee_code : strtoupper(auth()->user()->role) }}
            </div>
        </div>
        <span style="font-size: 10px; padding: 2px 8px; border-radius: 10px;
                     background: rgba(99,102,241,0.15); color: #818cf8; font-weight: 600;
                     letter-spacing: 0.05em; white-space: nowrap;">
            {{ strtoupper(auth()->user()->role) }}
        </span>
    </div>
</div>

<style>
    #searchContainer:focus-within {
        border-color: rgba(99,102,241,0.5) !important;
        background: var(--input-focus-bg) !important;
    }
    #notificationDropdown:hover {
        background: var(--sb-hover-bg) !important;
        color: var(--text-primary) !important;
    }
</style>

{{-- Global Search Script --}}
<script>
(function () {
    const searchInput   = document.getElementById('globalSearch');
    const searchResults = document.getElementById('searchResults');
    let debounceTimer = null;
    let currentXhr    = null;

    if (!searchInput || !searchResults) return;

    const groupConfig = {
        employees:    { label: 'พนักงาน',   icon: 'fas fa-user-tie',      color: '#818cf8' },
        items:        { label: 'สินค้า',     icon: 'fas fa-box',          color: '#34d399' },
        requisitions: { label: 'ใบเบิก',     icon: 'fas fa-file-alt', color: '#fbbf24' },
        departments:  { label: 'แผนก',       icon: 'fas fa-building',          color: '#38bdf8' },
        positions:    { label: 'ตำแหน่ง',    icon: 'fas fa-briefcase',          color: '#a78bfa' },
    };

    function performSearch(query) {
        if (query.length < 2) { searchResults.style.display = 'none'; return; }
        if (currentXhr) currentXhr.abort();
        currentXhr = new XMLHttpRequest();
        currentXhr.onreadystatechange = function () {
            if (currentXhr.readyState === 4) {
                currentXhr = null;
                if (this.status === 200) renderResults(JSON.parse(this.responseText));
            }
        };
        currentXhr.open('GET', '{{ route('search') }}?q=' + encodeURIComponent(query), true);
        currentXhr.send();
    }

    function renderResults(data) {
        let html = '', hasResults = false;
        for (const [type, config] of Object.entries(groupConfig)) {
            const results = data[type] || [];
            if (!results.length) continue;
            hasResults = true;
            html += '<div style="padding: 8px 12px 4px; font-size: 10px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted);">'
                  + '<i class="' + config.icon + ' me-1"></i>' + config.label
                  + ' <span style="background: var(--input-bg); color: var(--text-muted); font-size: 10px; padding: 1px 6px; border-radius: 8px;">' + results.length + '</span></div>';
            results.forEach(function (item) {
                html += '<a href="' + item.route + '" class="d-flex align-items-start gap-2 px-3 py-2 text-decoration-none search-result-item" '
                      + 'style="color: var(--text-secondary); transition: background 0.1s;">'
                      + '<i class="' + item.icon + ' mt-1" style="font-size: 13px; color: ' + config.color + '; flex-shrink: 0;"></i>'
                      + '<div><div style="font-size: 13px; font-weight: 500; color: var(--text-primary);">' + escapeHtml(item.title) + '</div>'
                      + '<div style="font-size: 11px; color: var(--text-muted);">' + escapeHtml(item.subtitle) + '</div></div></a>';
            });
        }
        if (!hasResults) {
            html = '<div style="padding: 32px 12px; text-align: center; color: var(--text-muted);">'
                 + '<i class="fas fa-search" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>'
                 + '<span style="font-size: 13px;">ไม่พบผลลัพธ์</span></div>';
        }
        searchResults.innerHTML = html;
        searchResults.style.display = 'block';
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        const q = this.value.trim();
        debounceTimer = setTimeout(() => performSearch(q), 280);
    });

    searchInput.addEventListener('focus', function () {
        if (this.value.trim().length >= 2) performSearch(this.value.trim());
    });

    document.addEventListener('click', function (e) {
        if (!searchResults.contains(e.target) && e.target !== searchInput)
            searchResults.style.display = 'none';
    });

    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); searchInput.focus(); searchInput.select(); }
        if (e.key === '/' && !['INPUT','TEXTAREA','SELECT'].includes(document.activeElement.tagName)) { e.preventDefault(); searchInput.focus(); }
        if (e.key === 'Escape' && document.activeElement === searchInput) { searchInput.blur(); searchResults.style.display = 'none'; }
    });

    document.addEventListener('mouseover', function (e) {
        const item = e.target.closest('.search-result-item');
        if (item) item.style.background = 'var(--table-hover-bg)';
    });
    document.addEventListener('mouseout', function (e) {
        const item = e.target.closest('.search-result-item');
        if (item) item.style.background = '';
    });
})();
</script>