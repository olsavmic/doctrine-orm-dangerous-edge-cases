# Dangerous Doctrine edge-cases you should know

1. [Avoid #[OneToOne] relationships (Perf issue)](src/OneToOneTriggersAdditionalQuery/README.md)
2. [Beware of Entity Inheritance (Perf issue)](src/InheritanceCausesAdditionalQuery/README.md)
3. [Do not introduce complex logic to $entity->get*EntityIdentifier* (Perf issue)](src/ComplexEntityIdentifier/README.md)
4. [Private methods do not trigger `Doctrine\ORM\Proxy->__ load` (runtime failure)](src/PrivateMethodNotTriggeringProxyLoad/README.md)
5. [Do not reassign Collections, use `$collection->clear()` (consistency issue)](src/CollectionReassignment/README.md)
6. [Beware of cascade persist (consistency issue)](src/ManualPersistWithCascadeOnCollection/README.md)
7. [Do not introduce __toString() on Entity classes (consistency issue)](src/EntityToString/README.md)

## Local setup

You need `docker` and `docker compose v2` installed.

### Test locally

- `printf "UID=$(id -u)\nGID=$(id -g)" > .env`
- `docker compose up -d`
- `docker compose run -it app bash`
- `composer install && composer prepare-database`
- `composer test` -> Some tests are supposed to fail, you're supposed experiment with those cases individually
