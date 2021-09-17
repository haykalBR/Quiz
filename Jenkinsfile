node {
    currentBuild.result = "SUCCESS"
    try {
        stage('Clone sources ') {
          echo '> Checking out the Git version control ...'
          git branch: 'develop', credentialsId: 'bcb3d411-c5eb-4a36-ac9a-88d423d6f2c5', url: 'https://gitlab.com/immonext/immopanel.git'

        }
        stage('Build Docker') {
           echo 'Build applicattion with docker'
           sh 'make build'
           sh 'make start '
           sh 'docker-compose exec -T  php composer install'
        }
        stage('Tests') {
          parallel (
                phpCs: { sh 'docker-compose exec -T php vendor/bin/phpcs'},
                phpStan: { sh 'docker-compose exec -T php vendor/bin/phpstan analyse'},
                phpUnit: { sh 'docker-compose exec -T php vendor/bin/phpunit'},
             )
        }
       stage('Deploy') {
         echo '> Deploying the application ...'
         sh '  ansible-playbook tools/ansible/deploy.yml -i tools/ansible/inventories/dev.yml -f 5 -u dev  --key-file  /var/lib/jenkins/.ssh/id_rsa'
         emailext body: ' build Ok ', subject: 'Build Sucess', to: 'haikelbrinis@gmail.com'
     }
    } catch(error) {
        currentBuild.result = "FAILURE"
        throw err
    } finally {
    }
}