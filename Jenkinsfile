import groovy.json.JsonSlurperClassic

@NonCPS
def parseJsonToMap(String json) {
    final slurper = new JsonSlurperClassic()
    return new HashMap<>(slurper.parseText(json))
}

def loadCreds(secretFile){
    withCredentials([file(credentialsId: secretFile, variable: 'MY_SECRET_FILE')]) {
        script {
            MY_SECRET_FILE_CONTENT = sh (
                script: "cat ${MY_SECRET_FILE}",
                returnStdout: true
            ).trim()
            return parseJsonToMap(MY_SECRET_FILE_CONTENT)
        }
    }
}

def deployCode(creds) {
    echo "Sending files to remote server"
    echo "rsync -uvrn --delete --exclude-from ${WORKSPACE}/CI/exclude-file.txt ${WORKSPACE}/* ${creds.sshUser}@${creds.sshServer}:${creds.sshRemotePath};"
    sh "rsync -uvr --delete --exclude-from ${WORKSPACE}/CI/exclude-file.txt ${WORKSPACE}/* ${creds.sshUser}@${creds.sshServer}:${creds.sshRemotePath};"
}

def deployDbChanges(creds){
    echo "Sending db changes to remote server"
    sh "rsync -uvr --delete ${WORKSPACE}/CI/DB/scripts/* ${creds.sshUser}@${creds.sshServer}:${creds.dbFolder};"
}

def execDbChanges(creds,hostenv){
    echo "Launching DB migration then Deleting migration files";
    sh "ssh ${creds.sshUser}@${creds.sshServer} \"cd ${creds.sshRemotePath}/web/app/uploads && sh db/db-migration-remote.sh $hostenv && rm -Rf db/* && exit\"";
    echo "-- Your database should be up to date";
}

@NonCPS
def getChangeString() {
    MAX_MSG_LEN = 100
    def changeString = "${JOB_NAME}${env.BUILD_DISPLAY_NAME}\n"

    def changeLogSets = currentBuild.rawBuild.changeSets
    for (int i = 0; i < changeLogSets.size(); i++) {
        def entries = changeLogSets[i].items
        for (int j = 0; j < entries.length; j++) {
            def entry = entries[j]
            truncated_msg = entry.msg.take(MAX_MSG_LEN)
            changeString += " - ${truncated_msg} [${entry.author}]\n"
        }
    }

    if (!changeLogSets) {
        changeString += " - No new changes"
    }
    return changeString
}

pipeline {
  agent any
  stages {
    stage('Build') {
      steps {
        script{
            echo "Starting Build, triggered by $BRANCH_NAME";
            echo "Building ${env.BUILD_ID} on ${env.JOB_URL}";
            sh 'composer install';
            sh 'npm install';
            sh 'npm run sprites';
            sh 'npm run build';
        }
      }
    }
    stage('Deploy preprod') {
        when { branch 'develop' }
        steps {
            script {
                echo "Deploying Develop Branch"
                def creds = loadCreds('wonderwp_credentials');
                deployCode(creds);
                deployDbChanges(creds);
                execDbChanges(creds,'preprod');
            }
        }
    }
    stage('Test preprod') {
        when { branch 'develop' }
        steps {
            echo 'Starting Smoke Tests'
            sh 'node_modules/.bin/cypress run --spec cypress/integration/smoke_test.js --env host=http://www.wonderwp.com.wdf-02.ovea.com'
        }
    }
    stage('notify'){
        steps {
            script {
                slackSend(message: getChangeString(), channel: '#jenkins', color: 'good', failOnError: true, teamDomain: 'wdf-team', token: 'ebmZ6kgsvWsgFVUY3UViZPOS')
            }
        }
    }
  }
}

