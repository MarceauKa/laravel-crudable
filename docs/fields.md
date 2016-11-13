# Fields

Fields are the way to bring power to your model attributes.  
Many are available and all are customizable to your needs.

## API

Each field can be attached to you model via the `getCrudFields` method on your `Crudable` model.
And each of them share the same base API and some have their own additionnal API.

```php
public function getCrudFields()
{
    return CrudFields::make([
        // Your fields
    ]);
}
```

### Attaching

The minimum working code is (rules are facultatives):
```php
TextField::handle('your-attribute', 'your-rules')
// or
new TextField('your-attribute', 'your-rules')
```

### Customizing

Once declared, you can use the Field API to declare your modifiers.

- Declaring Rules: `withRules(array|string $rules)`:  
They're your field validation rules and they are the same as Laravel Validation.

- Customize the label: `withLabel(string $lavel)`:  
Allows you to customize the label that'll be displayed on the form. By default, if your identifier is `title` it will be displayed `Title`.

- Customize the placeholder: `withPlaceholder(string $placeholder)`:  
Allows you to customize the placeholder displayed on the input form. By default, it's empty.

- Customize the help message: `withHelp(string $help)`:  
Allows you to customize the help message displayed above on the input form. By default, it's empty.

- Display or not in the table: `displayInColumns(bool $state)`:  
Enable or disable the field on the entries table. Defaults to `true`.

## Fields reference

### TextField

It's a basic `<input type="text" />`.  

View: `fields/text.blade.php`

### TextareaField

It's a basic HTML textarea.  

View: `fields/textarea.blade.php` 

### RadioField

Simple HTML radio.  

View: `fields/radio.blade.php` 

Methods: 

- `withOptions(array $options)`  
When called, `in:...options` validation rule is added.

```php
RadioField::handle('status')->withOptions([0 => 'Draft', 1 => 'Live']);
```

### EmailField

Same as [TextField](#textfield) but takes care of the email contained.  

View: `fields/email.blade.php` 

### TinymceField

Same as [TextareaField](#textareafield) but produces a WYSIWYG via [TinyMCE 4](https://www.tinymce.com/).  
To use it you should read [Fields with assets](#fields-with-assets).  

View: `fields/tinymce.blade.php` 

### FileUploadField

File upload field. You can specify extensions authorized, max filesize, upload path and storage disk.  
Once added this field will add `enctype="multipart/form-data"` to the entry form.  
By default; this field value is not displayed in the entries table.  

View: `fields/fileupload.blade.php` 

Methods: 

- `withTypes(string $types)`  
It's similar to the laravel validation rule 'mimes' and can be used to restrict the file to the given extensions.

- `withMaxSize(int $size)`  
It's similar to the laravel validation rule 'max' and can be used to restrict the maximum file size (given in kB).

- `uploadToPath(string $path)`  
It's the uploaded file destination. Ex: /uploads`.  

- `uploadToDisk(string $disk)`  
It's the storage disk used for the uploaded file. Defaults to `public`.

## Fields with assets

Some fields such as [TinymceField](#tinymcefield) comes with custom assets.  

Default form views will insert the two custom blade sections `crud_js` and `crud_css`.  
To work properly you must include `@yield('crud_js')` and `@yield('crud_css')` somewhere in your blade layout.

Fields assets are published in `public/vendor/crud/` when you call the command `php artisan vendor:publish --tag=crud`.