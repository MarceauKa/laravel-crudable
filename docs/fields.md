# Fields

Fields are the way to bring power to your model attributes.  
Many are available and all are customizable to your needs.

## Usage

Each field can be attached to your model via the `getCrudFields` method on your `Crudable` model.
And each of them share the same base API and some have their own additionnal API.

```php
public function getCrudFields()
{
    return CrudFields::make([
        // Your fields
    ]);
}
```

## Attach fields

The minimum working code is:
```php
TextField::handle('your-attribute')
// or
new TextField('your-attribute')
```

You can pass your rules as second parameter:
```php
TextField::handle('your-attribute', 'required|min:3')
```

## Fields reference

### TextField

It's a basic `<input type="text" />`.  

View: `fields/text.blade.php`  
Extends: `Field`  
Trait: -  

### TextareaField

It's a basic HTML textarea.  

View: `fields/textarea.blade.php`  
Extends: `Field`  
Trait: -  

### RadioField

Simple HTML radio.  

View: `fields/radio.blade.php`  
Extends: `Field`  
Trait: `FieldWithOptions`  

Additional API:
```php
$field = RadioField::handle('status');

// Add radio options as an array. Takes care to add validation rules.
// The second parameter is the default value but it can be null.
$field->withOptions([0 => 'Dra`ft', 1 => 'Live'], 1);
```

### EmailField

Same as [TextField](#textfield) but takes care of the email contained.  

View: `fields/email.blade.php` 
Extends: `Field`  
Trait: -  

### TinymceField

Same as [TextareaField](#textareafield) but produces a WYSIWYG via [TinyMCE 4](https://www.tinymce.com/).  
To use it you should read [Fields with assets](#publishing-assets).  

View: `fields/tinymce.blade.php`  
Extends: `Field`  
Trait: -  

### FileUploadField

File upload field. You can specify extensions authorized, max filesize, upload path and storage disk.  
Once added this field will add `enctype="multipart/form-data"` to the entry form.  
By default; this field value is not displayed in the entries table.  

View: `fields/fileupload.blade.php`  
Extends: `Field`  
Trait: `FieldHandleUpload`  

Additional API:
```php
$field = FileUploadField::handle('illustration');

// Only accept this mimes.
// Default: empty
$field->withTypes('jpeg,png');  

// Set the maximum file size (in kB)
// Default: empty
$field->withMaxSize(1024 * 1024);  

// Set the upload destination folder on the disk.
// Default: 'uploads'
$field->uploadToPath('uploaded-illustrations');

// Set the disk that'll store uploads. Configure them in "config/filesystems.php".
// Default: 'public'.
$field->uploadToDisk('disk-name');
```

### SelectRelationField

This field adds a select input based on an existing model relation.  
For example, a Post model belongs to a Category model:  
```php
SelectRelationField::handle('category_id')->withRelation('category')
```

View: `fields/select-relation.blade.php`  
Extends: `Field`  
Trait: `FieldWithRelation`  

Additional API:
```php
$field = SelectRelationField::handle('category_id');

// The relation to use. The parameter is the name of the relation used in the model.
// Default: empty
$field->withRelation('category');  
```

### DatePickerField

This field provides a date picker (based on [Bootstrap Datepicker](https://github.com/uxsolutions/bootstrap-datepicker).

View: `fields/date-picker.blade.php`  
Extends: `Field`  
Trait: -  

Additional API:
```php
$field = DatePicker::handle('published_at');

// Customize the date format both used when saving and selecting a date in the picker.
// Default: 'Y-m-d'
$field->withDateFormat('Y-m-d');  

// Set a minimum selectable date. You can pass a date as a string or as a Carbon instance.
// The field will add needed rules to the validation.
// Default: empty
$field->withMinDate('2016-12-01');
$field->withMinDate(Carbon::now());

// Set a maximum selectable date. Same as min date.
// Default: empty
$field->withMaxDate('2016-12-01');
$field->withMaxDate(Carbon::now()->addDays(3));
```

## Customize fields

Once declared, you can use the Field API to declare your modifiers.

```php
$field = TextField::handle('title');

// Attach some additional validation rules
// Default: empty
$field->withRules('required|min:3');

// Change the displayed label for this tield
// Default: Capitalized attribute name
$field->withLabel('The title');

// Set an input pladeholder
// Default: empty
$field->withPlaceholder('Ex: Hello world');

// Set a custom help message
// Default: empty
$field->withHelp('This is the title of your post');

// Show this field on the entries table ?
// Default: true
$field->displayInColumns(true);
```

## Publishing assets

Some fields such as [TinymceField](#tinymcefield) comes with custom assets.  

Default form views will insert the two custom blade sections `crud_js` and `crud_css`.  
To work properly you must include `@yield('crud_js')` and `@yield('crud_css')` somewhere in your blade layout.

Fields assets are published in `public/vendor/crud/` when you call the command `php artisan vendor:publish --tag=crud`.