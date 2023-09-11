# Form select birthday extension for laravel

This is a form control select birthday.

## Screenshot

## Installation

```bash
composer require mr4-lc/select-birthday
php artisan vendor:publish --tag=mr4-lc-select-birthday
```

## Configuration

## Usage

```php
<script>
    selectAlert = function(e) {
        console.log(e)
    }
</script>
{{-- Form::selectBirthday($name, $value = null, $options = [], $required = false, $onchange = '') --}}
{!! Form::selectBirthday('birthday1', '2023-09-10') !!}
{!! Form::selectBirthday(
    'birthday2',
    '1992-09-10',
    [
        'max' => \Carbon\Carbon::now()->subYear(20),
        'min' => \Carbon\Carbon::now()->subYear(200),
    ],
    true,
    'selectAlert'
) !!}
{!! Form::selectBirthday('birthday3', '1992-07-10', ['max' => '2003-09-11', 'min' => '1900-09-11']) !!}
{!! Form::selectBirthday('birthday4', null, [], true) !!}
{!! Form::selectBirthday('birthday5', '1992-09-10', [
    'max' => \Carbon\Carbon::now()->subYear(20),
    'min' => \Carbon\Carbon::now()->subYear(200),
    'class-form-group' => 'form-group mr4-lc-select-birthday',
    'class-form-control-year' => 'form-control year',
    'class-form-label-year' => '',
    'class-form-control-month' => 'form-control month',
    'class-form-label-month' => '',
    'class-form-control-day' => 'form-control day',
    'class-form-label-day' => '',
]) !!}
{!! Form::selectBirthday('birthday6', '1992-09-10', [
    'label' => [
        'year' => '年', // Default __('admin.year')
        'month' => '月', // Default __('admin.month')
        'day' => '日', // Default __('admin.day')
    ],
]) !!}
```

## License

Licensed under The [MIT License (MIT)](https://github.com/han48/mr4-lc.select-birthday/blob/main/LICENSE).
