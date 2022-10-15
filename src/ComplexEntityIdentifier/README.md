# Do not introduce complex logic to `$entity->get*EntityIdentifier*` (Perf issue)

## Problem:

- Accessing ID of Doctrine Proxies is free operation, except when the body of getId method is non-trivial
- See \Doctrine\Common\Proxy\ProxyGenerator::isShortIdentifierGetter

## Solutions:

- Do not add logic to entity getId() (or another method name, depending on the identifier), keep just simple return statement (`src/ComplexEntityIdentifier/Solution`)
