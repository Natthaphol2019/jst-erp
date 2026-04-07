# PHPUnit Tests for JST ERP System

This directory contains comprehensive PHPUnit tests for the JST ERP system.

## Test Structure

```
tests/
├── Unit/                    # Unit tests for models
│   ├── UserTest.php        # Tests for User model
│   ├── ItemTest.php        # Tests for Item model
│   └── EmployeeTest.php    # Tests for Employee model
├── Feature/                 # Feature tests for HTTP endpoints
│   ├── AuthTest.php        # Tests for authentication
│   ├── ItemCrudTest.php    # Tests for Item CRUD operations
│   └── EmployeeCrudTest.php # Tests for Employee CRUD operations
└── TestCase.php            # Base test case
```

## Running Tests

### Run all tests:
```bash
composer test
# or
php artisan test
```

### Run specific test file:
```bash
php artisan test --filter=UserTest
php artisan test tests/Unit/ItemTest.php
```

### Run with coverage (if xdebug is enabled):
```bash
php artisan test --coverage
```

## Test Configuration

The tests use SQLite in-memory database by default (configured in `phpunit.xml`):
- Database: `:memory:`
- This ensures tests are isolated and don't affect your development database

## What's Tested

### Unit Tests

#### User Model (14 tests)
- User creation
- Password hiding
- Employee relationship
- Role checking (isAdmin)
- Permission checking (hasPermission, canView, canCreate, etc.)
- Fillable attributes
- Different role types

#### Item Model (16 tests)
- Item creation
- Category relationship
- Stock transactions relationship
- Negative stock prevention
- Type checking (disposable, returnable)
- Type labels and badge styles
- Stock value casting
- Soft deletes
- Barcode/QR code URL generation

#### Employee Model (14 tests)
- Employee creation
- Department relationship
- Position relationship
- User relationship
- Time records relationship
- Fillable attributes
- Soft deletes
- Different statuses
- Unique employee codes
- Various gender values and prefixes

### Feature Tests

#### Authentication (13 tests)
- Login form display
- Login with valid/invalid credentials
- Validation requirements
- Logout functionality
- Role-based redirects (admin, manager, employee, hr, inventory)
- Remember me functionality

#### Item CRUD (21 tests)
- Index page with filtering and searching
- Create form and store validation
- Show details
- Edit form and update validation
- Image upload
- Delete with soft deletes
- Status toggle
- Sorting options

#### Employee CRUD (18 tests)
- Index page with filtering and searching
- Create form and store validation
- Show details
- Edit form and update validation
- Profile image upload
- Delete with soft deletes
- Department and status filtering
- Sorting options

## Database Factories

All tests use Laravel factories to create test data:

- `UserFactory` - Creates users with different roles
- `EmployeeFactory` - Creates employees with departments and positions
- `ItemFactory` - Creates inventory items
- `DepartmentFactory` - Creates departments
- `PositionFactory` - Creates positions
- `ItemCategoryFactory` - Creates item categories
- `StockTransactionFactory` - Creates stock transactions
- `TimeRecordFactory` - Creates time records

## Customizing Tests

### If your database schema differs:
Update the factories in `database/factories/` to match your actual column names.

### If routes are different:
Update the route names in Feature tests to match your `routes/web.php` file.

### To add more tests:
1. Create new test files in `tests/Unit` or `tests/Feature`
2. Follow the existing naming convention: `it_can_[action]` or `it_[does_something]`
3. Use `#[Test]` attribute or name methods starting with `test_`

## Troubleshooting

### Tests fail with column not found:
- Check that your factories match the actual database schema
- Look at the error message to see which column is missing
- Update the corresponding factory file

### Tests fail with route not found:
- Check `routes/web.php` for the correct route names
- Update the `route('name')` calls in Feature tests

### Tests fail with authentication errors:
- Make sure the auth configuration is correct in `config/auth.php`
- Check that the User model is correctly configured

## Best Practices

1. **Use RefreshDatabase trait**: Ensures each test starts with a clean database
2. **Use factories**: Don't hardcode test data, use factories instead
3. **Test one thing per test**: Keep tests small and focused
4. **Use descriptive names**: Test names should describe what's being tested
5. **Test both success and failure**: Test valid and invalid inputs
6. **Mock external dependencies**: Use mocks for external services

## Notes

- The `RolePermission` class is mocked in User tests to isolate User model testing
- Feature tests use `actingAs()` to authenticate users
- All file uploads use `UploadedFile::fake()` for testing
- Soft deletes are tested to ensure data isn't permanently removed

## Additional Resources

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [PHPUnit Manual](https://phpunit.de/manual.html)
- [Laravel Factory Documentation](https://laravel.com/docs/database-testing)
