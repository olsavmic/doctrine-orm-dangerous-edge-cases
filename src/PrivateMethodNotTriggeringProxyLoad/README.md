# Private methods do not trigger `\Doctrine\ORM\Proxy->__load` (runtime failure)

## Problem:
- When a non-public method/property is accessed on a proxy object and the proxy was not loaded yet, it will fail on `$property must not be accessed before initialization`.
This is particularly dangerous in case of recursive relations as you can access private properties of the same class but different instance directly and in case of `clone` methods.
- See https://www.doctrine-project.org/projects/doctrine-orm/en/2.13/cookbook/accessing-private-properties-of-the-same-class-from-different-instance.html
 
## Solutions:
- Use only public methods when working with instances other than `$this` (even thought PHP allows you to access private properties of the same class but different instance) --> May ruin encapsulation 
- Explicitly trigger the proxy load by calling `$object->__load` before accessing private property/method
