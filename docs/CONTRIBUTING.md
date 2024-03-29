# Contributing

Contributions are **welcome** and will be fully **credited**.

Please read and understand the contribution guide before creating an issue or pull request.

## Etiquette

This project is open source, and as such, the maintainers give their free time to build and maintain the source code
held within. They make the code freely available in the hope that it will be of use to other developers. It would be
extremely unfair for them to suffer abuse or anger for their hard work.

Please be considerate towards maintainers when raising issues or presenting pull requests. Let's show the
world that developers are civilized and selfless people.

It's the duty of the maintainer to ensure that all submissions to the project are of sufficient
quality to benefit the project. Many developers have different skillsets, strengths, and weaknesses. Respect the maintainer's decision, and do not be upset or abusive if your submission is not used.

## Viability

When requesting or submitting new features, first consider whether it might be useful to others. Open
source projects are used by many developers, who may have entirely different needs to your own. Think about
whether or not your feature is likely to be used by other users of the project.

## Procedure

Before filing an issue:

- Attempt to replicate the problem, to ensure that it wasn't a coincidental incident.
- Check to make sure your feature suggestion isn't already present within the project.
- Check the pull requests tab to ensure that the bug doesn't have a fix in progress.
- Check the pull requests tab to ensure that the feature isn't already in progress.

Before submitting a pull request:

- Check the codebase to ensure that your feature doesn't already exist.
- Check the pull requests to ensure that another person hasn't already submitted the feature or fix.

## Requirements

If the project maintainer has any additional requirements, you will find them listed here.

- **[Laravel Coding Standard](https://laravel.com/docs/9.x/pint)** - We use the package [Laravel pint](https://laravel.com/docs/9.x/pint) to apply the conventions.

  - The configuration used can be checked [here](../pint.json)

- **[PHPStan - PHP Static Analysis Tool](https://phpstan.org/user-guide/getting-started)** - We use the package [phpstan/phpstan](https://github.com/phpstan/phpstan) associated with [nunomaduro/larastan](https://github.com/nunomaduro/larastan) to execute PHP static code analysis.

  - The configuration used can be checked [here](../phpstan.neon.dist)

- **Add tests!** - Your patch won't be accepted if it doesn't have tests.

- **Document any change in behaviour** - Make sure the [README.md](README.md) and any other relevant documentation are kept up-to-date.

- **Commit Message Guidelines** - We try to follow [Conventional Commits v1.0.0](https://www.conventionalcommits.org/en/v1.0.0/). We use the following to apply this convention.

  - [Git Commit Message Editor (vs code extension)](https://marketplace.visualstudio.com/items?itemName=phoihos.git-commit-message-editor)
  - [Conventional Commits (vs code extension)](https://marketplace.visualstudio.com/items?itemName=vivaxy.vscode-conventional-commits)
  - Inform whenever possible, the scope of the changes
  - Avaiable scopes:
    - action
    - api
    - auth
    - composer
    - config
    - controller
    - core
    - css
    - database
    - event
    - exception
    - git
    - job
    - js
    - lang
    - log
    - model
    - npm
    - policy
    - route
    - service
    - validation
    - view

- **Consider our release cycle** - We try to follow [SemVer v2.0.0](https://semver.org/spec/v2.0.0.html). Randomly breaking public APIs is not an option.

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please [squash them](https://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages) before submitting.

**Happy coding**!
