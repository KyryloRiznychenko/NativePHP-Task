<h3>How to run</h3>

1) Firstable you need to up containers via the next command: **docker-compose up [--force-recreate]**
2) The next step is to dive into the **test-php-fpm** container via the next command: **docker exec -ti test-php-fpm
   sh**
3) After these steps, you need to set up the.env file.
3) After all these manipulations, you can run the app from the root path via the next command: **php
   ./public/index.php [./tests/index.csv]
   [1|0]**.

<h3>Explanations of command arguments</h3>

<p>The second arg response of a csv file path</p>
<p>The third arg response of which rate repository is needed to run. false will trigger hardcoded rate repo, true -> Exchangeratesapi rate repo

<p>For the run test, you need to run this command <strong>./vendor/bin/phpunit</strong> into the <strong>test-php-fpm</strong> container</p>