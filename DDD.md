<h1 align="center">Laravel <a href="https://en.wikipedia.org/wiki/Domain-driven_design" target="_blank">DDD</a> (Domain-driven design)</h1>
<h3 align="center">Major software design approach implemented in <a href="https://laravel.com" target="_blank">Laravel</a> inspired by <a href="https://laravel-beyond-crud.com" target="_blank">LARAVEL BEYOND CRUD</a>.</h3>

# Content
- [Monster Controllers](#monster-controllers)
- [What Is DDD?](#what-is-ddd)
- [What Is Domain?](#what-is-domain)
- [Domains And Applications](#domains-and-applications)
- [Files Structure](#files-structure)
- [Structuring Unstructured Data](#structuring-unstructured-data)
- [Actions](#actions)
- [Dependency Illustration](#dependency-illustration)
- [Shared Directory](#shared-directory)
- [Models](#models)
- [MVC as DDD](#mvc-as-ddd)
- [How To think From Now On?](#how-to-think-from-now-on)
- [More To Read](#more-to-read)

## Monster Controllers
Usually, in REST APIs and for the majority of your classic **CRUD** controllers there might be a strict one-to-one mapping between models and controllers, and when the project starts getting bigger, the controllers will depend on other models rather than depending only on its main model, as shown in the example:
```php
class ProductController extends Controller
{
    public function __construct(
        protected App\Models\Product $product,
        protected App\Models\Invoice $invoice
    ) {}
}
```

In this article we are trying to solve this problem and many others, That's why we need to make a further distinction between what is domain code, and what is not.

## What Is DDD?
Software development approach that tries to bring the business language and the source code as close as possible.

## What Is Domain?
A set of **business problems** you're trying to solve, usually called “modules”.

## Domains And Applications
On the one hand, there's the domain, representing all the business logic, and on the other hand, we have code that uses — that is, consumes — that domain to integrate it with the framework and exposes it to the end-user.

Applications provide the infrastructure for end-users to access and manipulate the domain functionality in a user-friendly way.

## Files Structure
Here's the folder structure of a domain-oriented project:

    src/Domain/Invoices/
    ├── Actions
    ├── QueryBuilders
    ├── Collections
    ├── Data
    ├── Events
    ├── Exceptions
    ├── Listeners
    ├── Models
    ├── Rules
    └── States
    src/Domain/Products/
    ├── Actions
    └── .....

And this is what the application layer would look like:

    The admin HTTP application:
    src/App/Admin/
    ├── Products
        ├── Controllers
        ├── Middlewares
        ├── Requests
        ├── Resources
        ├── Queries
        ├── Filters
        └── ViewModels
    The REST API application
    src/App/Api/
    ├── Products
        ├── Controllers
        ├── Middlewares
        ├── Requests
        ├── Queries
        ├── Filters
        └── Resources
    The REST API application
    src/App/Console/
    └── Commands

## Structuring Unstructured Data
Take a look at the following code:
```php
function store(CreateCustomerRequest $request, Customer $customer)
{
    $validated = $request->validated();
    $customer->name = $validated['name'];
    $customer->email = $validated['email'];
    // …
}
```
I think we are all familiar with the previous code, but what is its problem? we don't know exactly what data is available in the $validated array and what is the type of it.

this case is very famous in our applications and can happen in many other cases. and in order to find out the data inside the array you must do one of the following things:

- Read the source code.
- Read the documentation.
- Dump $validated to inspect it.
- Use a debugger to inspect it.

To solve this, we can use Data transfer objects to present this data.
```php
class CustomerData
{
    public function __construct(
        public string $name,
        public string $email,
        public Carbon $birth_date,
    ) {}
}

// in controller
$data = new CustomerData(...$customerRequest->validated());
```

In our applications, the DOTs will be used to present your data. so, we should forget the usage of arrays when transferring data between application and domain layers.

Also, you should note that we can still use parameters with `string`, `int`, and other data types as passed parameters to the domain actions.

To improve your DTO usages you can use this [package](https://spatie.be/docs/laravel-data/v2/introduction) which is already installed and configured.

## Actions
Simple classes without any abstractions or interfaces. An action is a class that takes input, does something, and gives output.

```php
class CreateCustomerAction
{
    public function __construct(
        private Customer $customer
        ) {
    }

    public function handle(CustomerData $customerData): Customer
    {
        return $this-customer->create($customerData->toArray());
    }
}
```

invokable:
```php
class CreateCustomerAction
{
    public function __construct(
        private Customer $customer
        ) {
    }

    public function __invoke(CustomerData $customerData): Customer
    {
        return $this-customer->create($customerData->toArray());
    }
}
```

And this action will called from the controller.
```php
    public function create(CreateCustomerRequest $request): JsonResponse
    {
        $this->authorize('create', Customer::class);
        $customer = CreateCustomerAction::run(new CustomerData(...$customerRequest->validated()));
        return $customer ? $this->okResponse($customer) : $this->failedResponse();
    }
```

**Note:** it is recommended to use [API Resource](https://laravel.com/docs/9.x/eloquent-resources) as transformation layer  for the JSON responses.

## Dependency Illustration
[![](https://mermaid.ink/img/pako:eNptkV9PwjAUxb9KcxMSTCZh_90eTIBifJAggi8yHup2lSVbO9suERnf3bIFwYS3tud37jnp3UMqMoQYPiWrtmRFE04IGa1fFcoNub29bx5Xq2ci8atGpRsy7k8E11IUBUoySnUu-E1rGbcwXc0bMulTUbKc_9MnJ51UUlQodY6qIbQ_M_FFh9AjQprl4omoVOaViZuuKdPsnSnctMi0QxY1yp0pperCQPTSPTez2TH2T56c86_J43N90rygqgRX2JDRhaub0OudqAfU6Za0JRp60uiVamY2WFCiNN-RmU_eH-EE9BZLTCA2R461lqxIIOEHg7Jai-WOpxBrWaMFdZUxjTRnZj0lxB-sUOYVs1wLOesW1-7PgorxNyHKk9FcId7DN8SOGwx8Jwoj2w6dyL3zXQt2ENueM_C80I3CILKDoe17Bwt-2gnDQeCFjh_4vmuH7jDwncMvtzCokg?type=png)](https://mermaid.live/edit#pako:eNptkV9PwjAUxb9KcxMSTCZh_90eTIBifJAggi8yHup2lSVbO9suERnf3bIFwYS3tud37jnp3UMqMoQYPiWrtmRFE04IGa1fFcoNub29bx5Xq2ci8atGpRsy7k8E11IUBUoySnUu-E1rGbcwXc0bMulTUbKc_9MnJ51UUlQodY6qIbQ_M_FFh9AjQprl4omoVOaViZuuKdPsnSnctMi0QxY1yp0pperCQPTSPTez2TH2T56c86_J43N90rygqgRX2JDRhaub0OudqAfU6Za0JRp60uiVamY2WFCiNN-RmU_eH-EE9BZLTCA2R461lqxIIOEHg7Jai-WOpxBrWaMFdZUxjTRnZj0lxB-sUOYVs1wLOesW1-7PgorxNyHKk9FcId7DN8SOGwx8Jwoj2w6dyL3zXQt2ENueM_C80I3CILKDoe17Bwt-2gnDQeCFjh_4vmuH7jDwncMvtzCokg)

## Shared Directory

The `src/shared/` directory is used for everything going to be used by the application and the domain. so, this is left to the developer to decide when creating a new trait, enum, or helper class.

## Models
You must maintain your models as simple as possible, so they will only contain the `relations`, `attributes`, `casts`, and maybe `$guarded` and `$table` etc, and regarding the queries, they must be written in the domain actions, not inside the model, same thing for scopes, collection methods and observers.

Here is simple model example:
```php
<?php

namespace Domain\Client\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{
    use SoftDeletes;

    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'favorable_id',
        'favorable_type'
    ];
}
```

You can read more about the following topics to keep your models simple:
- [Model States](https://spatie.be/docs/laravel-model-states/v2/working-with-states/01-configuring-states).
- [Model Query builder](https://timacdonald.me/dedicated-eloquent-model-query-builders/).
- [Model Observer](https://laravel.com/docs/9.x/eloquent#observers-and-database-transactions ).
- [Model Collection](https://www.youtube.com/watch?v=Q0DMyBzzmN8).

## MVC As DDD
Can we say that DDD is different from MVC? I think it is better to say that the M letter in the MVC which refers to Models has been extended to be Domain that includes the actions, DTOs, enums, and many other things instead of Model.

## How To Think From Now On?
When you have a new task, you will think about the business problem and how to achieve your solution inside the domain regardless of the application, so you probably will start defining the actions required and then create a new action or more, select what you need from the existing actions if needed, and define the DTOs needed in these actions. after that, you will start using the actions in your application layer by passing the required input DTO to the actions and getting the returned DTO as result.

## More To Read:
-   [Static analysis](https://tsh.io/blog/php-static-code-analysis).
-   [Type system](https://www.php.net/manual/en/language.types.type-system.php).
-   [State design pattern](https://refactoring.guru/design-patterns/state/php/example).
-   [Factory design pattern](https://refactoring.guru/design-patterns/factory-method/php/example).
-   [Why Not Use Repository Pattern?](https://www.youtube.com/watch?v=giJcdfW2wC8)
-   [Event Sourcing](https://laravel-news.com/event-sourcing-in-laravel)
-   DDD articles from [stitcher.io](https://stitcher.io).
    -   [Domain Oriented Laravel](https://stitcher.io/blog.laravel-beyond-crud-01-domain-oriented-laravel)
    -   [Working With Data](https://stitcher.io/blog/laravel-beyond-crud-02-working-with-data)
    -   [Actions](https://stitcher.io/blog/laravel-beyond-crud-03-actions)
    -   [Models](https://stitcher.io/blog/laravel-beyond-crud-04-models)
    -   [States](https://stitcher.io/blog/laravel-beyond-crud-05-states)
    -   [Managing Domains](https://stitcher.io/blog/laravel-beyond-crud-06-managing-domains)
    -   [Application Layer](https://stitcher.io/blog/laravel-beyond-crud-07-entering-the-application-layer)
    -   [View Models](https://stitcher.io/blog/laravel-beyond-crud-08-view-models)
    -   [Test Factories](https://stitcher.io/blog/laravel-beyond-crud-09-test-factories)
