# Sign In App

<!-- * [Live Site](https://www.signinapp.com/) -->
* [Dev Site](https://signinapp.trainor.dev/)

## Development

Run `composer install` and `yarn install` in the root directory to install dependencies.

Run `yarn dev` in the root directory to startup the development server.


## Deployment

Run `composer install --no-dev` and `yarn install` in the root directory to install dependencies.

Run `yarn run build`

## Crontab

The following tasks need to be added to the server's crontab file

```sh
0 0 * 1-12 0-6 [project-path]/vendor/bin/sake dev/tasks/App-Task-GenerateDailyTimesheets
```


ROI Calculator

Center and put number underneath
