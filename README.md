# 🦑 Laravel Sqids

<a href="https://github.com/istiak-tridip/laravel-sqids/actions"><img alt="Test Status" src="https://img.shields.io/github/actions/workflow/status/istiak-tridip/laravel-sqids/run-tests.yaml?label=tests"></a>
<a href="https://packagist.org/packages/istiak-tridip/laravel-sqids"><img src="https://img.shields.io/packagist/dt/istiak-tridip/laravel-sqids" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/istiak-tridip/laravel-sqids"><img src="https://img.shields.io/packagist/v/istiak-tridip/laravel-sqids" alt="Latest Version"></a>
<a href="https://packagist.org/packages/istiak-tridip/laravel-sqids"><img src="https://img.shields.io/packagist/l/istiak-tridip/laravel-sqids" alt="License"></a>

**Laravel Sqids** is a lightweight wrapper around [Sqids](https://sqids.org/) (pronounced "squids"), an open-source library for generating short, URL-safe, non-sequential, and unique identifiers from numbers.

This package simplifies the integration of Sqids into your Laravel application, providing a clean and efficient way to obscure raw database IDs in URLs, forms, or other scenarios where unique, aesthetically pleasing
identifiers are needed without storing them in the database.

---

#### ✨ Features:

- **Unique IDs**: Generates short, collision-free IDs that are unique to your application.
- **Model-Specific IDs**: Produces distinct IDs for each model to ensure uniqueness across models.
- **Route Model Binding**: Automatically resolves route model bindings with the generated IDs.
- **Convenient Helpers**: Includes query scopes for easy filtering and an option to configure numeric-only IDs.

## Installation

Install the package via Composer:

```bash
composer require istiak-tridip/laravel-sqids
```

> [!IMPORTANT]
> This package requires **PHP 8.2 or higher** and is compatible with **Laravel 11.x and 12.x**.

If you need to customize the default configuration, publish the config file:

```bash
php artisan vendor:publish --tag=sqids-config
```

## 🚀 Getting Started

To use Sqids with a model, simply add the `HasSqids` trait to your model:

```php
use Istiak\Sqids\Concerns\HasSqids;

class User extends Model
{
    use HasSqids;
}
```

## 👩‍💻 Usage

### 🛠️ Accessing Sqids

You can access the Sqid directly from the model:

```php
$user = User::query()->first();

echo $user->refid; // Outputs the Sqid for the model's ID
```

If needed, you can decode the Sqid back to the original ID:

```php
// Throws an exception on failure
$id = $user->sqids()->decode($user->refid);

// Returns null on failure
$id = $user->sqids()->decodeOrNull($user->refid);
```

---

### 🔍 Query Helpers

When querying models using Sqids, you can use the provided query scopes instead of manually decoding the Sqids:

```php
// Find a single model by Sqid
$user = User::query()->whereSqid($sqid)->first();

// Find multiple models by Sqids
$users = User::query()->whereSqidIn([$sqid1, $sqid2])->get();
```

---

### 🔗 Route Model Binding

The package automatically resolves route model bindings using Sqids. You can define your routes as usual:

```php
// GET /invoices/86Rf07xd4z
Route::get('/invoices/{record}', function (Invoice $record) {
    return $record->number;
});
```

In this example, the `Invoice` model will be resolved using the Sqid provided in the route.

---

### 🔢 Generating Numeric IDs

If you need numeric-only Sqids (e.g., `4622014635`), configure the package to use a numeric alphabet in the `AppServiceProvider`'s `boot` method:

```php
use Istiak\Sqids\Support\Config;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Config::generateNumericIds();
    }
}
```

This ensures all generated Sqids consist only of numbers.

## 🔄 Alternatives

If this package doesn’t meet your needs, here are some alternative packages you can explore:

- **[red-explosion/laravel-sqids](https://github.com/red-explosion/laravel-sqids)**
  Another awesome Laravel package for integrating Sqids, offering a different implementation approach and features like prefixed Sqids.

- **[sqids/sqids-php](https://github.com/sqids/sqids-php)**
  The official PHP implementation of Sqids. Ideal for those who don’t require Laravel-specific integrations.

## 📜 License

**Laravel Sqids** was created by [Istiak Tridip](https://github.com/istiak-tridip) and is open-sourced under the [MIT License](./LICENSE.md).
