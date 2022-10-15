# Avoid `#[OneToOne]` relationships (performanceissue)
## Problem:

`#[OneToOne]` relationship always triggers eager load on the inverse side (where the join column is missing)

→ Additional query for each entity in the result-set! (possibly thousands)

## Solutions:

- Move the `#[JoinColumn]` to the entity that is heavily utilised (e.g. ignore the problem as it does not really cause performance issues)
  Remove inverse relation, use Repository to retrieve it when needed (`src/OneToOneTriggersAdditionalQuery/InverseSideRemovedSolution`)
- Switch to artificial `#[OneToMany]`, `#[ManyToOne]`, keep the original public entity interface (`src/OneToOneTriggersAdditionalQuery/OneToManySolution`)
