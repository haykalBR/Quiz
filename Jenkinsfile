node {
     environment {
        FAILURE = credentials("FAILURE")
        ENV_DEVELOP = credentials("ENV_DEVELOP")
        SUCCESS = credentials("SUCCESS")
    }
    try {
        stage('Clone sources ') {
          echo '> Checking out the Git version control ...'
          git branch: 'develop', credentialsId: 'bcb3d411-c5eb-4a36-ac9a-88d423d6f2c5', url: 'https://gitlab.com/immonext/immopanel.git'
        }
        stage('Build Docker') {
           echo 'Build applicattion with docker'
           echo 'docker stop $(docker ps -a -q)'
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
         emailext body: "Completed ${ENV_DEVELOP} (< ${ BUILD_URL }|build ${BUILD_NUMBER}>) ${SUCCESS}  - <${BUILD_URL}console|click here to see the console output ", subject: "Build ${SUCCESS}-${BUILD_NUMBER}", to: 'haikelbrinis@gmail.com'
     }
    } catch(error) {
        result = "FAILURE"
        emailext body: "Completed ${ENV_DEVELOP} (< ${ BUILD_URL }|build ${BUILD_NUMBER}>) ${FAILURE}  - <${BUILD_URL}console|click here to see the console output ", subject: "Build ${FAILURE}-${BUILD_NUMBER}", to: 'haikelbrinis@gmail.com'
        throw err
    } finally {
    }
}