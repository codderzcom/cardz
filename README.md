# CARDZ

## Preface

This repo is an attempt to style a "Bonus Cards API" with the DDD approach using the bare bones of Laravel.

There are some stipulations we're trying to uphold:

- isolate the project code from the framework as much as possible;
- isolate the domain as much as possible;
- construct a modular monolith in such a way to make the future transition to the microservice architecture relatively
  painless;
- try to keep code complexity under control;
- demonstrate most of the major strategic and tactic DDD patterns somewhat to the detriment of the previous provision;
- demonstrate the implementation of the CQRS pattern, Event Sourcing (with event storage) pattern, ABAC Auth and some
  other interesting approaches, once again to the probable detriment of the code simplicity;
- provide the bare minimum of tests required to keep a decent level of maintainability.

Please, note that we purposely break the YAGNI principle for the demo, scalability and maintainability reasons.   
We are aware that this code is not, in fact, the most simple or efficient. Furthermore, we fully agree that the bounded
contexts here (especially the core ones) are suboptimal and might not be the best possible representation of the domain.
However, we feel they are good enough for now, and they should be malleable enough to future changes and redesign.

We've willfully discarded the considerations of high load and a score of other potential hurdles, as they are beyond
what this application aims to be.

There has been no particular reason to choose the Laravel framework, it could've been Symfony, or Zend, or anything else
really, as long as it had a router, a DI container, an ORM and other frameworky stuff.

Take a look at the [lightweight version of this app](https://github.com/codderzcom/queues) to compare near-enterprise and startup approaches.

## Domain

### Story

Some café owners got together and decided that they need a new way to attract more customers. One such way would be to
implement a loyalty program where each customer is given some card with the predefined requirements for a bonus. When
the requirements are met the card owner becomes eligible for the bonus. Requirements are generally in the line of buying
some specific type of coffee or food. For example, a bonus scheme may be described as "_Buy eight cups of espresso and
get a cappuccino for free_" or "_Buy latte, mocha, and cappuccino and get a free lungo_". Each time the requirement is
met it's marked on the card as an achievement.

Once the bonus is received the card lifecycle is completed, and it should be treated as irrelevant.

Requirements can wary for each café and a bonus plan. The system should mostly keep records of what is or should be done
rather than try to control or limit the café owners and managers.

Each owner can establish an unlimited* number of workspaces where they can create an unlimited* number of bonus plans. A
plan is basically a description of requirements (which number, you've guessed it, is unlimited*) and a bonus in free
form.

There's no need to be formal, so no proof of ownership or whatever is required. Basically, every registered user can
start a workspace.

Once a workspace is established its keeper can invite more people to work there. Generally, that would be servers,
baristas, bartenders, and so on.

Only the collaborators of the same workspace can introduce the changes to the plans, create new ones, and launch them.
New collaborators can be invited only by the keeper.

The customer identifies themselves via the mobile app after which they can be issued a card for the specific plan. There
are no restrictions* on the number of cards a customer can own for each plan or a workspace. Remember, that we're trying
to keep things simple and flexible for a large variety of owners and businesses.

__

_*unlimited - within reasonable limits, but that's not in the sphere of our current considerations._

### Event storming diagram

N/A

### Ubiquitous language

#### Terms

After some back and forth between the owners the following terms were coined for the domain:

- **customer** - any system user
- **workspace** - a place where some business is conducted, be it a café, a restaurant, or a gift shop. There is no
  support for the chains and franchises, each place is considered to be a separate workspace.
- **keeper** - a person who has created a workspace.
- **collaborator** - a person who has accepted an invitation to work in a workspace.
- **plan** - some kind of bonus program
- **requirement** - a description of the prerequisite required to receive a bonus
- **card** - a place to track customer's progress towards a bonus obtainment
- **achievement** - a completed requirement marked in a card

Actually, the terms need to be specified separately for each context, but for this small app the dictionary above
provides sufficient description.

### Contexts

There are four Core contexts: **Cards**, **Personal**, **Plans** and **Workspaces**, two Support ones: **Collaboration**
and **MobileAppGateway**, and two Generic ones: **Authorization** and **Identity**. MobileAppGateway is not, strictly
speaking, a context, more of a gateway, but can be considered as such. Authorization is based on an extremely simple
ABAC-like engine designed to serve as a demo for the generic authorization usage in a DDD project with eventually
consistent intercontext communication.  
Identity is just a wrap on Laravel Sanctum.

#### Context map

N/A

## Further work

- we need to provide more documentation on the thought process and its implementation in the code;
- more context-specific docs are required for each module;
- tests need to be refactored for more clarity and ease of reading;
- we'd like to introduce a microservice implementation of app alongside this one;
- shared code has to be remade into the proper vendor library.

## Installation instructions

- clone the [repo](https://github.com/codderzcom/cardz) with `git clone`;
- ensure you have **PHP 8.0+**;
- run `composer install`;
- copy `.env.example` to `.env`;
- provide your app key with `php artisan key:generate`;
- make sure you have **PostgreSQL** installed and running;
- create a relevant database and provide credentials for the DB connection in your `.env` file;
- run migrations for your DB with the `php artisan migrate` command;
- launch `php artisan serve` and proceed to the provided localhost page to take a look at the project API documentation.

Optionally, you can run `php artisan tests` to take a look at the small assortment of included tests.

The RabbitMQ messaging is faked, so there's no need to install RabbitMQ for now.

### Code structure

Most of the app code lies within the `src` directory. Parts of the infrastructure unrelated to the domain are in
the `codderz` directory. Consider it a kind of external lib.   
A small bit of an app code is in the `app` directory mostly due to the Laravel structure.
