# Beware of Entity Inheritance (performanceissue)
## Problem:

When entity has relation to another entity that is part of Inheritance hierarchy, then loading the owning entity will cause additional query to determine which subclass should be loaded

→ Additional query for each entity in the result-set! (possibly thousands)

## Solutions:

- You **usually do not need inheritance**
- Manually add `JOIN` and `SELECT` to the `DQL` queries (`tests/src/InheritanceCausesAdditionalQuery/Solution/OccurrenceTest.php`)
