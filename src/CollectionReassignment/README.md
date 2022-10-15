# Do not reassign Collections, use `$collection->clear()` (consistency issue)

## Problem:
Due to bug in UnitOfWork change-set calculation that was reported almost a year ago (https://github.com/doctrine/orm/pull/9301), it's dangerous to reassign collections in some special cases.
Typically, the problem is triggered by calling `$entityManager->flush()` multiple times -> the first call clears the change-set, the second call then does not detect the need to delete old collection data.

## Solutions:
- Always use `$collection->clear()` instead of reassigning the collection (`src/CollectionReassignment/Solution/Article.php`)
