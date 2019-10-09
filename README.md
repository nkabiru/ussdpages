# UssdPages

This is a demo app showing how the [State design pattern](https://en.wikipedia.org/wiki/State_pattern) can be used to create complex
ussd menus.

##Uses:
 * Laravel 6
 * Africa's Talking USSD Sandbox API
 
## Notes
1. The classes in the `Ussd` folder represent the various states.
2. The `input()` method represents the transition between states.
    * Each state responds to `input` differently.
3. The `Context` classes manage what gets displayed to the user.
4. Some functionality had to be placed in the `view` methods of some states.

### Advantages
1. Extensible - new states can be created easily by creating classes that implement
the `State` interface.
2. Clean - each class has concise, understandable methods (hopefully).

### Disadvantages
1. Complexity - the State pattern may be difficult to grasp without first understanding
OOP and SOLID
2. Numerous files - if a lot of states are involved.
3. `view()` methods have side-effects.
