# Role-based Authorization with CakePHP

Running CakePHP and want to use Roles for Authorization? Well here's a quick app that demonstrates one way of doing it!

## Install

 Get the cake core, and replace the app folder contents with this app.

     git clone git://github.com/cakephp/cakephp.git auth-roles
     cd auth-roles
     rm -rf app
     git clone git@github.com:josegonzalez/role-auth-codebase.git app

Then run the sql schema file, located in `app/Config/Schema/schema.sql`.

## Usage

Ultra secure login info:

- Username: `username`
- Password: `password`

Just load up the app in your browser and log in!

## Weird stuff

I was lazy, so instead of writing out actions for the entire `PostsController`, I just used the CakePHP scaffolding feature to create a `_getScaffold` method and always return a json response. This means it supports any action name...

The `PostsController::isAuthorized()` method does the interesting work. It will retrieve the current user - from the db, so you can modify the user at will! - and check to see if the current `controller::action` is in the user's roles. This currently only works in the `PostsController`, but you can make the change to have this work anywhere if you wanted.

All roles are named in the form `controller::action`.

The AuthComponent setup is in the `AppController::beforeFilter()`.

I have a custom `AppController::_refreshUser()` method that can be used to get the current user from the db - assuming that info is based on a user id in the session. It simulates `BaseAuthenticate::_findUser`.

`AppModel` has `recursive` set to `-1` and `actsAs` `ContainableBehavior`. This lets me do fun stuff I guess. You need `ContainableBehavior` in order for the roles to be pulled into the session on login.

`Role hasAndBelongsToMany User`

## TODO

- Unit tests (yeah right, this shit works)

## License

Copyright (c) 2012 Jose Diaz-Gonzalez

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.