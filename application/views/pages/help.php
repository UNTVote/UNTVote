 <!-- Main body content -->
<?php if($this->ion_auth->logged_in()):?>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<?php endif?>
        <div class="col-xs-11 col-sm-10 col-md-8 col-lg-6 panel panel-default block-center fade-on-load" hidden>
          <h1>Help &amp; support</h1>
          <hr>

          <p>Below you will find a curated list of basic how-to topics. If you can't find what you are looking for please submit your question through our <a href="<?=site_url('contact/')?>" alt="Contact page">contact page.</a></p>


          <h2 class="text-muted-2x">Accounts</h2>
          <h4>How do I:</h4>
          <div class="panel-group" id="accounts" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accounts" href="#createAccount" aria-expanded="true" aria-controls="createAccount">
                    Create an account?
                  </a>
                </h4>
              </div>
              <div id="createAccount" class="panel-collapse collapse" role="tabpanel" aria-labelledby="createAccount">
                <div class="panel-body">
                  To vote or run for an election a member account is necessary. Accounts can only be created with a valid UNT email account. Open up the homepage and on the right side of screen will be the registration form. Fill out all required fields and click on "Register for UNTVote". If your information is valid, you will be forwarded to a sign in screen where you should see a message notifying you of the successful account creation. You can now login with the registered EUID and password.
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                  <a class="collapsed" data-toggle="collapse" data-parent="#accounts" href="#signIn" aria-expanded="false" aria-controls="signIn">
                    Sign in to my account?
                  </a>
                </h4>
              </div>
              <div id="signIn" class="panel-collapse collapse" role="tabpanel" aria-labelledby="signIn">
                <div class="panel-body">
                  If you already have an account, open up the UNTVote homepage and click on "Sign in" button at the top right corner. You will be directed to a sign in screen where you can sign in with your EUID and password.
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                  <a class="collapsed" data-toggle="collapse" data-parent="#accounts" href="#recoverPassword" aria-expanded="false" aria-controls="recoverPassword">
                    Recover my password?
                  </a>
                </h4>
              </div>
              <div id="recoverPassword" class="panel-collapse collapse" role="tabpanel" aria-labelledby="recoverPassword">
                <div class="panel-body">
                  Click on "Sign in" button on homepage. You will see the sign in input box  which has the password textbox. Click on "Forgot?" link next to password label. In the next dialog box enter the UNT email address you registered the account with and click submit. You will receive an email to the email account provided with a link to change your password.
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accounts" href="#changeAccount" aria-expanded="true" aria-controls="changeAccount">
                    Change account information?
                  </a>
                </h4>
              </div>
              <div id="changeAccount" class="panel-collapse collapse" role="tabpanel" aria-labelledby="changeAccount">
                <div class="panel-body">
                  Once you are signed into your account click on your name on the top right corner. Click on "Profile" from the menu. On the following page you will be able change your name, email address, password, college and your avatar. If you made any changes click on "Save changes" to apply those changes.
                </div>
              </div>
            </div>
          </div>

          <br>

          <h2 class="text-muted-2x">Elections</h2>
          <h4>How do I:</h4>
          <div class="panel-group" id="elections" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingThree">
                <h4 class="panel-title">
                  <a class="collapsed" data-toggle="collapse" data-parent="#elections" href="#browseElection" aria-expanded="false" aria-controls="browseElection">
                    Browse elections?
                  </a>
                </h4>
              </div>
              <div id="browseElection" class="panel-collapse collapse" role="tabpanel" aria-labelledby="browseElection">
                <div class="panel-body">
                  Login to your account and click on "Elections" from the sidebar and select "Browse". You will see a table with active and upcoming election that are available in your college category. Please note that you will not be able to see elections that are part of other colleges categories.
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingFour">
                <h4 class="panel-title">
                  <a class="collapsed" data-toggle="collapse" data-parent="#elections" href="#voteRequest" aria-expanded="false" aria-controls="voteRequest">
                    Request to vote?
                  </a>
                </h4>
              </div>
              <div id="voteRequest" class="panel-collapse collapse" role="tabpanel" aria-labelledby="voteRequest">
                <div class="panel-body">
                  In your account, click on "Elections" and then "Browse". A list of all active and upcoming elections will be displayed. Select which election you want to vote on and click "View election" button. Information particular to that election will be displayed and you can click on "Request to vote" button at the bottom to send a request to the election administrators.
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingFive">
                <h4 class="panel-title">
                  <a class="collapsed" data-toggle="collapse" data-parent="#elections" href="#vote" aria-expanded="false" aria-controls="vote">
                    Vote on an election?
                  </a>
                </h4>
              </div>
              <div id="vote" class="panel-collapse collapse" role="tabpanel" aria-labelledby="vote">
                <div class="panel-body">
                  To vote on an election you are required to request permission from election administrators. Once you are approved you can open the necessary election and if the election is active you will see options to select your candidate. Once you select a candidate click the "Submite vote" button at the bottom.
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingSeven">
                <h4 class="panel-title">
                  <a class="collapsed" data-toggle="collapse" data-parent="#elections" href="#viewResults" aria-expanded="false" aria-controls="viewResults">
                    View election results?
                  </a>
                </h4>
              </div>
              <div id="viewResults" class="panel-collapse collapse" role="tabpanel" aria-labelledby="viewResults">
                <div class="panel-body">
                  Click on "Elections" on the sidebar and click "Results". You will be shown a drop down box with a list of elections. Select the election that you want to view results for and you will be shown the actual results for that particular election.
                </div>
              </div>
            </div>
          </div>

          <br>

          <h2 class="text-muted-2x">Candidates</h2>
          <h4>How do I:</h4>
          <div class="panel-group" id="candidates" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingSix">
                <h4 class="panel-title">
                  <a class="collapsed" data-toggle="collapse" data-parent="#candidates" href="#browseCandidates" aria-expanded="false" aria-controls="browseCandidates">
                    Browse candidates?
                  </a>
                </h4>
              </div>
              <div id="browseCandidates" class="panel-collapse collapse" role="tabpanel" aria-labelledby="browseCandidates">
                <div class="panel-body">
                  In your account, click on "Candidates" on the sidebar. A list of all candidates will be displayed. If you need more information about an individual candidate click on "View profile" button.
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingSix">
                <h4 class="panel-title">
                  <a class="collapsed" data-toggle="collapse" data-parent="#candidates" href="#requestCandidacy" aria-expanded="false" aria-controls="requestCandidacy">
                    Request to be a candidate?
                  </a>
                </h4>
              </div>
              <div id="requestCandidacy" class="panel-collapse collapse" role="tabpanel" aria-labelledby="requestCandidacy">
                <div class="panel-body">
                  In your account, click on "Candidates" on the sidebar. You will see a button that reads "Become a candidate". Click on that and a request will be sent to the election administrators. Once they approve it you will receive an email.
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingSix">
                <h4 class="panel-title">
                  <a class="collapsed" data-toggle="collapse" data-parent="#candidates" href="#editCandidate" aria-expanded="false" aria-controls="editCandidate">
                    Edit my candidate information?
                  </a>
                </h4>
              </div>
              <div id="editCandidate" class="panel-collapse collapse" role="tabpanel" aria-labelledby="editCandidate">
                <div class="panel-body">
                  Once you are logged in click on your name on top right corner. Then click on "Profile" from the menu. On the page that opens up click on "Candidate" tab. You will be able add/edit information about you and your goals. Once you are done making changes click on "Save changes" to save them to your candidate profile.
                </div>
              </div>
            </div>
          </div>
        </div>
        <br>
        <?php if($this->ion_auth->logged_in()):?>
        </div>
<?php endif?>
      </div>
    </div>