# Do not add __toString() to Entities (consistency issue)

## Problem:
PHP (and possibly Doctrine as well) is using `__toString()` in a lot of internal function that most programmers would expect strict equality comparison. By omitting `__toString` definition in entity classes,
we can avoid a lot of unexpected behavior as the code will fail on Error instead of silently returning a wrong value.

The example illustrates the problem on a simple `array_unique` call -> see that it's easy to write a test case that passes, it's enough to just flush the entities and therefore retrieve generated IDs.
Using pre-generated IDs is of course an option, but it can still surprise the programmer.


## Solutions:
- Omit `__toString` from entities
