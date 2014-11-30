<!-- Main body content -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h1 class="page-header">Vote log</h1>
  <div class="fade-on-load" hidden>
    <!-- Repeater-->
    <br>
    <div class="row">
      <div class="col-xs-12 fuelux">
        <div class="repeater" data-staticheight="350" id="confirmationTable">
          <div class="repeater-header">
            <div class="repeater-header-left">
              <div class="repeater-search">
                <div class="search input-group">
                  <input type="search" class="form-control" placeholder="Search" />
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                      <span class="glyphicon glyphicon-search"></span>
                      <span class="sr-only">Search</span>
                    </button>
                  </span>
                </div>
              </div>
            </div>
            <div class="repeater-header-right" hidden>
              <div class="btn-group selectlist repeater-filters" data-resize="auto">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                  <span class="selected-label">&nbsp;</span>
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Filters</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li data-value="all" data-selected="true"><a href="#">all</a>
                  </li>
                  <li data-value="some"><a href="#">some</a>
                  </li>
                  <li data-value="others"><a href="#">others</a>
                  </li>
                </ul>
                <input class="hidden hidden-field" name="filterSelection" readonly="readonly" aria-hidden="true" type="text" />
              </div>
              <div class="btn-group repeater-views" data-toggle="buttons">
                <label class="btn btn-default active">
                  <input name="repeaterViews" type="radio" value="list"><span class="glyphicon glyphicon-list"></span>
                </label>
                <label class="btn btn-default">
                  <input name="repeaterViews" type="radio" value="thumbnail"><span class="glyphicon glyphicon-th"></span>
                </label>
              </div>
            </div>
          </div>
          <div class="repeater-viewport">
            <div class="repeater-canvas"></div>
            <div class="loader repeater-loader"></div>
          </div>
          <div class="repeater-footer">
            <div class="repeater-footer-left">
              <div class="repeater-itemization">
                <span><span class="repeater-start"></span> - <span class="repeater-end"></span> of <span class="repeater-count"></span> items</span>
                <div class="btn-group selectlist" data-resize="auto">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="selected-label">&nbsp;</span>
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li data-value="5"><a href="#">5</a>
                    </li>
                    <li data-value="10" data-selected="true"><a href="#">10</a>
                    </li>
                    <li data-value="20"><a href="#">20</a>
                    </li>
                    <li data-value="50" data-foo="bar" data-fizz="buzz"><a href="#">50</a>
                    </li>
                    <li data-value="100"><a href="#">100</a>
                    </li>
                  </ul>
                  <input class="hidden hidden-field" name="itemsPerPage" readonly="readonly" aria-hidden="true" type="text" />
                </div>
                <span>Per Page</span>
              </div>
            </div>
            <div class="repeater-footer-right">
              <div class="repeater-pagination">
                <button type="button" class="btn btn-default btn-sm repeater-prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                  <span class="sr-only">Previous Page</span>
                </button>
                <label class="page-label" id="myPageLabel">Page</label>
                <div class="repeater-primaryPaging active">
                  <div class="input-group input-append dropdown combobox">
                    <input type="text" class="form-control" aria-labelledby="myPageLabel">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right"></ul>
                    </div>
                  </div>
                </div>
                <input type="text" class="form-control repeater-secondaryPaging" aria-labelledby="myPageLabel">
                <span>of <span class="repeater-pages"></span></span>
                <button type="button" class="btn btn-default btn-sm repeater-next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                  <span class="sr-only">Next Page</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>
</div>
</div>
