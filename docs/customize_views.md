# Customize views

All views are customizable and are stored in `resources/views/vendor/crud`.

Views are published to your app with the command:
```bash
php artisan vendor:publish --tag=crud
```

Here's the details of each views.

### Table view `table.blade.php`

- `$create_url` URL to the create form
- `$title` Title of the table
- `$count` Entries count
- `$is_empty` Empty or not?
- `$entries` Entries collection. Each entries calls the row view
- `$columns` An array containing names of columns

### Row view `row.blade.php`

- `$entry` The CrudEntry instance
- `$manager` The manager (descriptions is coming)
- `$actions` The entry buttons (not customizable yet)

### Form view `form-create.blade.php` and `form-update.blade.php`

- `$back_url` URL to the index view
- `$entry` CrudEntry instance itself
- `$errors` Validation errors
- `$old` Old inputs values
- `$title` Form title
- `$form_url` Form action URL
- `$form_method` Form method
- and more...

### Field view `fields/*.blade.php`

Each view is named by its field name.  
Ex: `fields/text.blade.php` for the `TextField`.

- `$field` Field instance itself 
- `$error` Validation error for the field 
- `$old` Old value for the field 
- and more...
