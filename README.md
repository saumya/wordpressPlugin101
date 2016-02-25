Wordpress plugin development - 101
==================================
	Lets say one just needs to write some functions and thats it.

Well, probably that's over simplification. But thats all one need to do.
 - Wordpress has global functions all over it.
 - Wordpress runs kind of in a procedural way.
 - Wordpress has some event hooks 
 - As a plugin developer, one just have to write a function for a particular hook

More on hooks in a second.

	So what a plugin developer is adding some functions to the crowded global functions space of Wordpress.

That means, one has to be careful enough to name to functions properly so that there might not be any name collisions.

Appart from a generic PHP functions, this project shows, how to load Javascript files inside wordpress and call the javascript functions.
	
	Hooks in Wordpress are points where one can insert code.

Its kind of events and we will execute some functions on that event.