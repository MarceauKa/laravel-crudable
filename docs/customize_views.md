# Customize views

All views are customizable and are stored in `resources/views/vendor/crud`.

Views are published to your app with the command:
```bash
php artisan vendor:publish --tag=crud
```

Here's the details of each views.

### Table view `table.blade.php`

- `$create_url` URL to the create form.
- `$title` Title of the table.
- `$count` Entries count. It's based on total rows and not on entries in the current page.
- `$is_empty` Empty or not? It's based on total rows and not on entries in the current page.
- `$entries` Entries collection. Each entries calls the row view.
- `$pagination` Pagination of the entries. Same as classic pagination.
- `$columns` An array containing names of columns.

### Row view `row.blade.php`

- `$entry` CrudEntry instance.
- `$manager` CrudManager instance.
- `$actions` The entry buttons. Not customizable yet.

### Form view `form-create.blade.php` and `form-update.blade.php`

- `$back_url` URL to the index view.
- `$entry` CrudEntry instance.
- `$errors` Validation errors.
- `$old` Old inputs values.
- `$title` Form title.
- `$form_url` Form action URL.
- `$form_method` Form method.
- and more...

### Field view `fields/*.blade.php`

Each view is named by its field name.  
Ex: `fields/text.blade.php` for the `TextField`.

- `$field` Field instance itself 
- `$error` Validation error for the field 
- `$old` Old value for the field 
- and more...
