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

def handleException(msg,exc) {
    def changeString_ = "${JOB_NAME}${env.BUILD_DISPLAY_NAME}\n";

    if(msg){
		changeString_ += msg;
    } else {
    	changeString_ += " - Build failed. ";
    }

    if(exc){
    	changeString_ += " | ";
    	changeString_ += exc.getMessage();
    }

    changeString_ +="\n<${env.RUN_DISPLAY_URL}|Voir le build>";

	notify(changeString_,"danger");
	if(exc){
		throw(exc);
	}
}

def notify(msg,color){
	slackSend(message: msg, channel: '#jenkins', color: color, failOnError: true, teamDomain: 'wdf-team', token: 'ebmZ6kgsvWsgFVUY3UViZPOS');
}

def deployCode(creds) {
    echo "Sending files to remote server"
    sh "rsync -uvr --delete --exclude-from ${WORKSPACE}/CI/exclude-file.txt ${WORKSPACE}/* ${creds.sshUser}@${creds.sshServer}:${creds.sshRemotePath};"
    if(creds.siteUrl){
        env.siteUrl = creds.siteUrl;
        env.slackMsg+="\n"+'<'+creds.siteUrl+'|Voir le site>';
    }
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

def defineVariables(){
	env.slackColor = "good";
	env.slackMsg = getChangeString();
	env.runComposer = false;
	env.runNpm = false;
	env.runBuild = false;
	env.runCypress=false;

	if(env.BUILD_ID.toInteger() < 10){
	    env.runComposer = true;
	    env.runNpm = true;
	    env.runBuild = true;
	    env.runCypress=true;
	}

	def changeLogSets_ = currentBuild.changeSets
	for (int i = 0; i < changeLogSets_.size(); i++) {
	  def entries_ = changeLogSets_[i].items
	  for (int j = 0; j < entries_.length; j++) {
	    def entry_ = entries_[j]
	    def files_ = new ArrayList(entry_.affectedFiles)
	    for (int k = 0; k < files_.size(); k++) {
	      def file_ = files_[k]
	      //println file_.path
	      if(file_.path=='composer.json' || file_.path=='composer.lock' || file_.path=='Jenkinsfile'){
	      	env.runComposer = true;
	      	env.runBuild = true;
	      	env.runCypress = true;
	      }
	      if(file_.path=='package.json' || file_.path=='package.lock' || file_.path=='Jenkinsfile'){
	      	env.runNpm = true;
	      }
	      if(file_.path.contains(".css") || file_.path.contains(".scss") || file_.path.contains(".js") || file_.path=='Jenkinsfile'){
			env.runBuild = true;
	      }
	      if(file_.path.contains(".php") || file_.path.contains(".js") || file_.path.contains('cypress')){
			env.runCypress = true;
	      }
	    }
	  }
	}

}


pipeline {
  agent any
  stages {
    stage('Build') {
      steps {
        script{
        	defineVariables();

            echo "Starting Build #${env.BUILD_ID}, triggered by $BRANCH_NAME";

            if(env.runComposer=='true'){
                try {
	                sh 'composer install --no-dev --prefer-dist';
                } catch(exc){
                    handleException('Composer install failed', exc);
                }
	        } else {
	        	echo 'skipped composer install';
	        }

	        if(env.runNpm=='true'){
	            try {
	        	    sh 'npm install';
                } catch(exc){
                    handleException('npm install failed',exc);
                }
	        } else {
	        	echo 'skipped npm install';
	        }

            if(env.runBuild=='true'){
	            try {
                    sh 'npm run sprites';
                    if(BRANCH_NAME=='master'){
                        sh 'npm run build:prod';
                    } else {
                        sh 'npm run build';
                    }
                } catch(exc){
                    handleException('Building the front failed',exc);
                }
            } else {
            	echo 'skipped npm sprites & build';
            }
        }
      }
    }
    stage('deploy develop branch') {
        when { branch 'develop' }
        steps {
            script {
            	try{
	                echo "Deploying Develop Branch"
	                def creds = loadCreds('wonderwp_credentials');
	                deployCode(creds);
	            } catch(exc){
	            	handleException('The develop branch deployment failed',exc);
                }
            }
        }
    }
    /*stage('deploy master branch') {
        when { branch 'master' }
        steps {
            script {
            	try {
	                echo "Deploying Master Branch"
	                def creds = loadCreds('your_prod_credentials');
	                deployCode(creds);
	            } catch(exc){
	            	handleException('The master branch deployment failed',exc);
                }
            }
        }
    }*/
    stage('Integration tests') {
        steps {
            script {
                try {
                    if(env.runCypress=='true'){
                        def host = '';
                        if(env.siteUrl){
                            host = env.siteUrl;
                            echo "Starting integration tests on $host"
                            sh "cypress run --env host=$host"
                        } else {
                            echo 'No host defined to run cypress against';
                        }
                    } else {
                        echo 'Skipped integration tests'
                    }
	            } catch(exc){
	            	handleException("Cypress tests failed, which means you have a problem on your $BRANCH_NAME live environment",exc);
                }
            }
        }
    }
    stage('notify'){
        steps {
            script {
    			notify(env.slackMsg,env.slackColor);
            }
        }
    }
  }
}
