# Installation

> Since version [`12.0`](https://github.com/Laravel-Lang/publisher/releases/tag/v12.0.0), the publisher does not include the mandatory installation of
> the [`laravel-lang/lang`](https://github.com/Laravel-Lang/lang) package. This is done for the convenience of [developing plugins](../plugins/installation.md) for the publisher.
> For
> example, [`laravel‑lang/http‑statuses`](https://github.com/Laravel-Lang/http-statuses).
>
> You can find a list of available plugins [here](../plugins/local.md).

To get the latest version of `Laravel Lang Publisher`, simply require the project using [Composer](https://getcomposer.org):

```bash
composer require laravel-lang/publisher laravel-lang/lang --dev
```

Or manually update `require-dev` block of `composer.json` and run `composer update`.

```json
{
    "require-dev": {
        "laravel-lang/lang": "^10.2",
        "laravel-lang/publisher": "^13.0"
    }
}
```

## Upgrade

To upgrade from previous versions, visit the [Upgrade](upgrade/index.md) page.
