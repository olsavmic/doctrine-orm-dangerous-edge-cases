# Beware of orphan removal (consistency issue)

## Problem:
Doctrine is unable to automatically (via orphanRemoval) delete entities that are still part of just ArrayCollection, not PersistentCollection.
Adding such entities to collection (and calling persist either manually or via `cascade=['persist']`) and calling `$collection->clear()` afterwards
will NOT DELETE the item from collection!

## Solutions:
- Do not use `orphanRemoval`, use dedicated service class instead (or pass EM to the entity class method as parameter)
