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

One declared, you can use the Field API to declare your modifiers.

- Declaring Rules: `withRules(array|string $rules)`:
They're your field validation rules and they are the same as Laravel Validation.

- Customize the label: `withLabel(string $lavel)`:
Allows you to customize the label that'll be displayed on the form. By default, if your identifier is `title` it will be displayed `Title`.

- Customize the placeholder: `withPlaceholder(string $placeholder)`:
Allows you to customize the placeholder displayed on the input form. By default, it's empty.

- Customize the help message: `withHelp(string $help)`:
Allows you to customize the help message displayed above on the input form. By default, it's empty.

## Fields reference

### TextField

It's a basic `<input type="text" />`.

### TextareaField

It's a basic HTML textarea.

### RadioField

Simple HTML radio.
This field auto-declare the validation rule `in:...options`.

```php
    RadioField::handle('status')->withOptions([0 => 'Draft', 1 => 'Live']);
```

### EmailField

Same as TextField but takes care of the email contained.

### TinymceField

Same as [TextareaField](#textareafield) but produces a WYSIWYG via [TinyMCE 4](https://www.tinymce.com/).
To use it you should read [Fields with assets](#fields-with-assets).

## Fields with assets

Some fields such as [TinymceField](#tinymcefield) comes with custom assets.
Default form views with will insert the two custom blade sections `crud_js` and `crud_css`.

To work properly you must include `@yield('crud_js')` and `@yield('crud_css')` somewhere in your blade layout.

Fields assets are published in `public/vendor/crud/` when you call the command `php artisan vendor:publish --tag=crud`.