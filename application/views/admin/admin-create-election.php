        <!-- Main body content -->
                <!-- Main body content -->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Create election</h1>
            <br>

            <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 block-center fade-on-load" hidden>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title" id="panelTitle">Untitled election</h3>
                </div>
                <div class="panel-body">
                  <!-- Form begins -->
                  <form method="post" accept-charset="utf-8" action="<?=site_url('elections/create')?>" role="form" id="formCreateElection" data-parsley-validate>
                  <?php echo $message;?>
                    <div class="row">
                      <div class="col-xs-12">
                        <label>Name</label>
                        <input name="electionName" type="text" class="form-control" id="electionName" placeholder="Descriptive election name" data-parsley-trigger="change" required autofocus>
                      </div>
                    </div>
                    <br>

                    <div class="row">
                      <div class="col-xs-12">
                        <label>Description</label>
                        <textarea name="electionDescription" class="form-control" rows="3" placeholder="Explain what the election is about" data-parsley-minlength="50" data-parsley-trigger="change" required></textarea>
                      </div>
                    </div>
                    <br>

                    <!-- Category dropdown -->
                    <div class="row">
                      <div class="col-xs-12 col-md-6">
                        <label>Category</label><br>
                        <select name="electionCollege" id="categoryList">
                          <?php foreach($colleges as $college):?>
                           <option value="<?=$college['id']?>"><?=$college['description']?></option>
                          <?php endforeach?>
                        </select>
                      </div>
                    </div>
                    <br>

                    <!-- Candidates dropdown -->
                    <div class="row">
                      <div class="col-xs-12">
                        <label>Candidates</label><br>
                        <select name="electionCandidates[]" id="candidateList" multiple="multiple">
                          <?php foreach($candidates as $candidate):?>
                            <option value="<?=$candidate['id']?>">
                              <?= htmlspecialchars($candidate['first_name'] . ' ' . $candidate['last_name'], ENT_QUOTES, 'UTF-8');?>
                            </option>
                          <?php endforeach?>
                        </select>
                      </div>
                    </div>
                    <br>

                    <!-- Datepickers -->
                    <div class="row">
                      <div class="col-xs-12 col-sm-6 fuelux">
                        <label>Start date</label>
                        <div class="datepicker dropup" id="startDate">
                          <div class="input-group">
                            <input name="electionStart" class="form-control" id="startDateInput" type="text" data-parsley-trigger="change" data-parsley-errors-container="#error-container-start-date" required/>
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-calendar"></span>
                                <span class="sr-only">Toggle Calendar</span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right datepicker-calendar-wrapper" role="menu">
                                <div class="datepicker-calendar">
                                  <div class="datepicker-calendar-header">
                                    <button type="button" class="prev"><span class="glyphicon glyphicon-chevron-left"></span><span class="sr-only">Previous Month</span></button>
                                    <button type="button" class="next"><span class="glyphicon glyphicon-chevron-right"></span><span class="sr-only">Next Month</span></button>
                                    <button type="button" class="title">
                                        <span class="month">
                                          <span data-month="0">January</span>
                                          <span data-month="1">February</span>
                                          <span data-month="2">March</span>
                                          <span data-month="3">April</span>
                                          <span data-month="4">May</span>
                                          <span data-month="5">June</span>
                                          <span data-month="6">July</span>
                                          <span data-month="7">August</span>
                                          <span data-month="8">September</span>
                                          <span data-month="9">October</span>
                                          <span data-month="10">November</span>
                                          <span data-month="11">December</span>
                                        </span> <span class="year"></span>
                                    </button>
                                  </div>
                                  <table class="datepicker-calendar-days">
                                    <thead>
                                    <tr>
                                      <th>Su</th>
                                      <th>Mo</th>
                                      <th>Tu</th>
                                      <th>We</th>
                                      <th>Th</th>
                                      <th>Fr</th>
                                      <th>Sa</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                  </table>
                                  <div class="datepicker-calendar-footer">
                                    <button type="button" class="datepicker-today">Today</button>
                                  </div>
                                </div>
                                <div class="datepicker-wheels" aria-hidden="true">
                                  <div class="datepicker-wheels-month">
                                    <h2 class="header">Month</h2>
                                    <ul>
                                      <li data-month="0"><button type="button">Jan</button></li>
                                      <li data-month="1"><button type="button">Feb</button></li>
                                      <li data-month="2"><button type="button">Mar</button></li>
                                      <li data-month="3"><button type="button">Apr</button></li>
                                      <li data-month="4"><button type="button">May</button></li>
                                      <li data-month="5"><button type="button">Jun</button></li>
                                      <li data-month="6"><button type="button">Jul</button></li>
                                      <li data-month="7"><button type="button">Aug</button></li>
                                      <li data-month="8"><button type="button">Sep</button></li>
                                      <li data-month="9"><button type="button">Oct</button></li>
                                      <li data-month="10"><button type="button">Nov</button></li>
                                      <li data-month="11"><button type="button">Dec</button></li>
                                    </ul>
                                  </div>
                                  <div class="datepicker-wheels-year">
                                    <h2 class="header">Year</h2>
                                    <ul></ul>
                                  </div>
                                  <div class="datepicker-wheels-footer clearfix">
                                    <button type="button" class="btn datepicker-wheels-back"><span class="glyphicon glyphicon-arrow-left"></span><span class="sr-only">Return to Calendar</span></button>
                                    <button type="button" class="btn datepicker-wheels-select">Select <span class="sr-only">Month and Year</span></button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="error-container-start-date"></div>
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-6 fuelux">
                        <label>End date</label>

                        <div class="datepicker dropup" id="endDate">
                          <div class="input-group">
                            <input name="electionEnd" class="form-control" id="endDateInput" type="text" data-parsley-trigger="change" data-parsley-errors-container="#error-container-end-date" required/>
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-calendar"></span>
                                <span class="sr-only">Toggle Calendar</span>
                              </button>
                              <div class="dropdown-menu dropdown-menu-right datepicker-calendar-wrapper" role="menu">
                                <div class="datepicker-calendar">
                                  <div class="datepicker-calendar-header">
                                    <button type="button" class="prev"><span class="glyphicon glyphicon-chevron-left"></span><span class="sr-only">Previous Month</span></button>
                                    <button type="button" class="next"><span class="glyphicon glyphicon-chevron-right"></span><span class="sr-only">Next Month</span></button>
                                    <button type="button" class="title">
                                        <span class="month">
                                          <span data-month="0">January</span>
                                          <span data-month="1">February</span>
                                          <span data-month="2">March</span>
                                          <span data-month="3">April</span>
                                          <span data-month="4">May</span>
                                          <span data-month="5">June</span>
                                          <span data-month="6">July</span>
                                          <span data-month="7">August</span>
                                          <span data-month="8">September</span>
                                          <span data-month="9">October</span>
                                          <span data-month="10">November</span>
                                          <span data-month="11">December</span>
                                        </span> <span class="year"></span>
                                    </button>
                                  </div>
                                  <table class="datepicker-calendar-days">
                                    <thead>
                                    <tr>
                                      <th>Su</th>
                                      <th>Mo</th>
                                      <th>Tu</th>
                                      <th>We</th>
                                      <th>Th</th>
                                      <th>Fr</th>
                                      <th>Sa</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                  </table>
                                  <div class="datepicker-calendar-footer">
                                    <button type="button" class="datepicker-today">Today</button>
                                  </div>
                                </div>
                                <div class="datepicker-wheels" aria-hidden="true">
                                  <div class="datepicker-wheels-month">
                                    <h2 class="header">Month</h2>
                                    <ul>
                                      <li data-month="0"><button type="button">Jan</button></li>
                                      <li data-month="1"><button type="button">Feb</button></li>
                                      <li data-month="2"><button type="button">Mar</button></li>
                                      <li data-month="3"><button type="button">Apr</button></li>
                                      <li data-month="4"><button type="button">May</button></li>
                                      <li data-month="5"><button type="button">Jun</button></li>
                                      <li data-month="6"><button type="button">Jul</button></li>
                                      <li data-month="7"><button type="button">Aug</button></li>
                                      <li data-month="8"><button type="button">Sep</button></li>
                                      <li data-month="9"><button type="button">Oct</button></li>
                                      <li data-month="10"><button type="button">Nov</button></li>
                                      <li data-month="11"><button type="button">Dec</button></li>
                                    </ul>
                                  </div>
                                  <div class="datepicker-wheels-year">
                                    <h2 class="header">Year</h2>
                                    <ul></ul>
                                  </div>
                                  <div class="datepicker-wheels-footer clearfix">
                                    <button type="button" class="btn datepicker-wheels-back"><span class="glyphicon glyphicon-arrow-left"></span><span class="sr-only">Return to Calendar</span></button>
                                    <button type="button" class="btn datepicker-wheels-select">Select <span class="sr-only">Month and Year</span></button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="error-container-end-date"></div>
                        </div>

                      </div>
                    </div>
                    <br>
                    <!-- Submit button -->
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Create election</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

        </div>
      </div>
    </div>