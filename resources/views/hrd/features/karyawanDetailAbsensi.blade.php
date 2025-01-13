@extends('layouts.main')

@section('title', 'HRD')

@section('sidebar-menu')

@include('hrd.menu')

@endsection

@section('content')

<div class="card card-primary">
  <div class="card-body p-0">
    <!-- THE CALENDAR -->
    <div id="calendar" class="fc fc-media-screen fc-direction-ltr fc-theme-bootstrap fc-liquid-hack">
      <div class="fc-header-toolbar fc-toolbar fc-toolbar-ltr">
        <div class="fc-toolbar-chunk">
          <div class="btn-group"><button type="button" title="Previous month" aria-pressed="false"
              class="fc-prev-button btn btn-primary"><span class="fa fa-chevron-left"></span></button><button
              type="button" title="Next month" aria-pressed="false" class="fc-next-button btn btn-primary"><span
                class="fa fa-chevron-right"></span></button></div><button type="button" title="This month" disabled=""
            aria-pressed="false" class="fc-today-button btn btn-primary">today</button>
        </div>
        <div class="fc-toolbar-chunk">
          <h2 class="fc-toolbar-title" id="fc-dom-1">January 2025</h2>
        </div>
        <div class="fc-toolbar-chunk">
          <div class="btn-group"><button type="button" title="month view" aria-pressed="true"
              class="fc-dayGridMonth-button btn btn-primary active">month</button><button type="button"
              title="week view" aria-pressed="false" class="fc-timeGridWeek-button btn btn-primary">week</button><button
              type="button" title="day view" aria-pressed="false"
              class="fc-timeGridDay-button btn btn-primary">day</button></div>
        </div>
      </div>
      <div aria-labelledby="fc-dom-1" class="fc-view-harness fc-view-harness-active" style="height: 340px;">
        <div class="fc-daygrid fc-dayGridMonth-view fc-view">
          <table role="grid" class="fc-scrollgrid table-bordered fc-scrollgrid-liquid">
            <tbody role="rowgroup">
              <tr role="presentation" class="fc-scrollgrid-section fc-scrollgrid-section-header ">
                <th role="presentation">
                  <div class="fc-scroller-harness">
                    <div class="fc-scroller" style="overflow: hidden scroll;">
                      <table role="presentation" class="fc-col-header " style="width: 457px;">
                        <colgroup></colgroup>
                        <thead role="presentation">
                          <tr role="row">
                            <th role="columnheader" class="fc-col-header-cell fc-day fc-day-sun">
                              <div class="fc-scrollgrid-sync-inner"><a aria-label="Sunday"
                                  class="fc-col-header-cell-cushion ">Sun</a></div>
                            </th>
                            <th role="columnheader" class="fc-col-header-cell fc-day fc-day-mon">
                              <div class="fc-scrollgrid-sync-inner"><a aria-label="Monday"
                                  class="fc-col-header-cell-cushion ">Mon</a></div>
                            </th>
                            <th role="columnheader" class="fc-col-header-cell fc-day fc-day-tue">
                              <div class="fc-scrollgrid-sync-inner"><a aria-label="Tuesday"
                                  class="fc-col-header-cell-cushion ">Tue</a></div>
                            </th>
                            <th role="columnheader" class="fc-col-header-cell fc-day fc-day-wed">
                              <div class="fc-scrollgrid-sync-inner"><a aria-label="Wednesday"
                                  class="fc-col-header-cell-cushion ">Wed</a></div>
                            </th>
                            <th role="columnheader" class="fc-col-header-cell fc-day fc-day-thu">
                              <div class="fc-scrollgrid-sync-inner"><a aria-label="Thursday"
                                  class="fc-col-header-cell-cushion ">Thu</a></div>
                            </th>
                            <th role="columnheader" class="fc-col-header-cell fc-day fc-day-fri">
                              <div class="fc-scrollgrid-sync-inner"><a aria-label="Friday"
                                  class="fc-col-header-cell-cushion ">Fri</a></div>
                            </th>
                            <th role="columnheader" class="fc-col-header-cell fc-day fc-day-sat">
                              <div class="fc-scrollgrid-sync-inner"><a aria-label="Saturday"
                                  class="fc-col-header-cell-cushion ">Sat</a></div>
                            </th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </th>
              </tr>
              <tr role="presentation"
                class="fc-scrollgrid-section fc-scrollgrid-section-body  fc-scrollgrid-section-liquid">
                <td role="presentation">
                  <div class="fc-scroller-harness fc-scroller-harness-liquid">
                    <div class="fc-scroller fc-scroller-liquid-absolute" style="overflow: hidden scroll;">
                      <div class="fc-daygrid-body fc-daygrid-body-unbalanced " style="width: 457px;">
                        <table role="presentation" class="fc-scrollgrid-sync-table"
                          style="width: 457px; height: 308px;">
                          <colgroup></colgroup>
                          <tbody role="presentation">
                            <tr role="row">
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past fc-day-other"
                                data-date="2024-12-29" aria-labelledby="fc-dom-2">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-2" class="fc-daygrid-day-number"
                                      aria-label="December 29, 2024">29</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past fc-day-other"
                                data-date="2024-12-30" aria-labelledby="fc-dom-4">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-4" class="fc-daygrid-day-number"
                                      aria-label="December 30, 2024">30</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past fc-day-other"
                                data-date="2024-12-31" aria-labelledby="fc-dom-6">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-6" class="fc-daygrid-day-number"
                                      aria-label="December 31, 2024">31</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past"
                                data-date="2025-01-01" aria-labelledby="fc-dom-8">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-8" class="fc-daygrid-day-number"
                                      aria-label="January 1, 2025">1</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a
                                        class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-past"
                                        style="border-color: rgb(245, 105, 84); background-color: rgb(245, 105, 84);">
                                        <div class="fc-event-main">
                                          <div class="fc-event-main-frame">
                                            <div class="fc-event-title-container">
                                              <div class="fc-event-title fc-sticky">All Day Event</div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="fc-event-resizer fc-event-resizer-end"></div>
                                      </a></div>
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past"
                                data-date="2025-01-02" aria-labelledby="fc-dom-10">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-10" class="fc-daygrid-day-number"
                                      aria-label="January 2, 2025">2</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past"
                                data-date="2025-01-03" aria-labelledby="fc-dom-12">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-12" class="fc-daygrid-day-number"
                                      aria-label="January 3, 2025">3</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past"
                                data-date="2025-01-04" aria-labelledby="fc-dom-14">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-14" class="fc-daygrid-day-number"
                                      aria-label="January 4, 2025">4</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                            </tr>
                            <tr role="row">
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past"
                                data-date="2025-01-05" aria-labelledby="fc-dom-16">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-16" class="fc-daygrid-day-number"
                                      aria-label="January 5, 2025">5</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past"
                                data-date="2025-01-06" aria-labelledby="fc-dom-18">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-18" class="fc-daygrid-day-number"
                                      aria-label="January 6, 2025">6</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past"
                                data-date="2025-01-07" aria-labelledby="fc-dom-20">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-20" class="fc-daygrid-day-number"
                                      aria-label="January 7, 2025">7</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past"
                                data-date="2025-01-08" aria-labelledby="fc-dom-22">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-22" class="fc-daygrid-day-number"
                                      aria-label="January 8, 2025">8</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-event-harness fc-daygrid-event-harness-abs"
                                      style="top: 0px; left: 0px; right: -130.567px;"><a
                                        class="fc-daygrid-event fc-daygrid-block-event fc-h-event fc-event fc-event-draggable fc-event-start fc-event-end fc-event-past"
                                        style="border-color: rgb(243, 156, 18); background-color: rgb(243, 156, 18);">
                                        <div class="fc-event-main">
                                          <div class="fc-event-main-frame">
                                            <div class="fc-event-time">12a</div>
                                            <div class="fc-event-title-container">
                                              <div class="fc-event-title fc-sticky">Long Event</div>
                                            </div>
                                          </div>
                                        </div>
                                      </a></div>
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 25px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past"
                                data-date="2025-01-09" aria-labelledby="fc-dom-24">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-24" class="fc-daygrid-day-number"
                                      aria-label="January 9, 2025">9</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 25px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past"
                                data-date="2025-01-10" aria-labelledby="fc-dom-26">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-26" class="fc-daygrid-day-number"
                                      aria-label="January 10, 2025">10</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 25px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past"
                                data-date="2025-01-11" aria-labelledby="fc-dom-28">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-28" class="fc-daygrid-day-number"
                                      aria-label="January 11, 2025">11</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                            </tr>
                            <tr role="row">
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past"
                                data-date="2025-01-12" aria-labelledby="fc-dom-30">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-30" class="fc-daygrid-day-number"
                                      aria-label="January 12, 2025">12</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-today "
                                data-date="2025-01-13" aria-labelledby="fc-dom-32">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-32" class="fc-daygrid-day-number"
                                      aria-label="January 13, 2025">13</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a
                                        class="fc-daygrid-event fc-daygrid-dot-event fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-today">
                                        <div class="fc-daygrid-event-dot" style="border-color: rgb(0, 115, 183);"></div>
                                        <div class="fc-event-time">10:30a</div>
                                        <div class="fc-event-title">Meeting</div>
                                      </a></div>
                                    <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a
                                        class="fc-daygrid-event fc-daygrid-dot-event fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-today">
                                        <div class="fc-daygrid-event-dot" style="border-color: rgb(0, 192, 239);"></div>
                                        <div class="fc-event-time">12p</div>
                                        <div class="fc-event-title">Lunch</div>
                                      </a></div>
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-future"
                                data-date="2025-01-14" aria-labelledby="fc-dom-34">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-34" class="fc-daygrid-day-number"
                                      aria-label="January 14, 2025">14</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a
                                        class="fc-daygrid-event fc-daygrid-dot-event fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-future">
                                        <div class="fc-daygrid-event-dot" style="border-color: rgb(0, 166, 90);"></div>
                                        <div class="fc-event-time">7p</div>
                                        <div class="fc-event-title">Birthday Party</div>
                                      </a></div>
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-future"
                                data-date="2025-01-15" aria-labelledby="fc-dom-36">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-36" class="fc-daygrid-day-number"
                                      aria-label="January 15, 2025">15</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-future"
                                data-date="2025-01-16" aria-labelledby="fc-dom-38">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-38" class="fc-daygrid-day-number"
                                      aria-label="January 16, 2025">16</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-future"
                                data-date="2025-01-17" aria-labelledby="fc-dom-40">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-40" class="fc-daygrid-day-number"
                                      aria-label="January 17, 2025">17</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-future"
                                data-date="2025-01-18" aria-labelledby="fc-dom-42">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-42" class="fc-daygrid-day-number"
                                      aria-label="January 18, 2025">18</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                            </tr>
                            <tr role="row">
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-future"
                                data-date="2025-01-19" aria-labelledby="fc-dom-44">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-44" class="fc-daygrid-day-number"
                                      aria-label="January 19, 2025">19</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-future"
                                data-date="2025-01-20" aria-labelledby="fc-dom-46">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-46" class="fc-daygrid-day-number"
                                      aria-label="January 20, 2025">20</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-future"
                                data-date="2025-01-21" aria-labelledby="fc-dom-48">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-48" class="fc-daygrid-day-number"
                                      aria-label="January 21, 2025">21</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-future"
                                data-date="2025-01-22" aria-labelledby="fc-dom-50">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-50" class="fc-daygrid-day-number"
                                      aria-label="January 22, 2025">22</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-future"
                                data-date="2025-01-23" aria-labelledby="fc-dom-52">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-52" class="fc-daygrid-day-number"
                                      aria-label="January 23, 2025">23</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-future"
                                data-date="2025-01-24" aria-labelledby="fc-dom-54">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-54" class="fc-daygrid-day-number"
                                      aria-label="January 24, 2025">24</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-future"
                                data-date="2025-01-25" aria-labelledby="fc-dom-56">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-56" class="fc-daygrid-day-number"
                                      aria-label="January 25, 2025">25</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                            </tr>
                            <tr role="row">
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-future"
                                data-date="2025-01-26" aria-labelledby="fc-dom-58">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-58" class="fc-daygrid-day-number"
                                      aria-label="January 26, 2025">26</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-future"
                                data-date="2025-01-27" aria-labelledby="fc-dom-60">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-60" class="fc-daygrid-day-number"
                                      aria-label="January 27, 2025">27</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-future"
                                data-date="2025-01-28" aria-labelledby="fc-dom-62">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-62" class="fc-daygrid-day-number"
                                      aria-label="January 28, 2025">28</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a
                                        class="fc-daygrid-event fc-daygrid-dot-event fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-future"
                                        href="https://www.google.com/">
                                        <div class="fc-daygrid-event-dot" style="border-color: rgb(60, 141, 188);">
                                        </div>
                                        <div class="fc-event-time">12a</div>
                                        <div class="fc-event-title">Click for Google</div>
                                      </a></div>
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-future"
                                data-date="2025-01-29" aria-labelledby="fc-dom-64">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-64" class="fc-daygrid-day-number"
                                      aria-label="January 29, 2025">29</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-future"
                                data-date="2025-01-30" aria-labelledby="fc-dom-66">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-66" class="fc-daygrid-day-number"
                                      aria-label="January 30, 2025">30</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-future"
                                data-date="2025-01-31" aria-labelledby="fc-dom-68">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-68" class="fc-daygrid-day-number"
                                      aria-label="January 31, 2025">31</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-future fc-day-other"
                                data-date="2025-02-01" aria-labelledby="fc-dom-70">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-70" class="fc-daygrid-day-number"
                                      aria-label="February 1, 2025">1</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                            </tr>
                            <tr role="row">
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-future fc-day-other"
                                data-date="2025-02-02" aria-labelledby="fc-dom-72">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-72" class="fc-daygrid-day-number"
                                      aria-label="February 2, 2025">2</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-future fc-day-other"
                                data-date="2025-02-03" aria-labelledby="fc-dom-74">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-74" class="fc-daygrid-day-number"
                                      aria-label="February 3, 2025">3</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-future fc-day-other"
                                data-date="2025-02-04" aria-labelledby="fc-dom-76">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-76" class="fc-daygrid-day-number"
                                      aria-label="February 4, 2025">4</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-future fc-day-other"
                                data-date="2025-02-05" aria-labelledby="fc-dom-78">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-78" class="fc-daygrid-day-number"
                                      aria-label="February 5, 2025">5</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-future fc-day-other"
                                data-date="2025-02-06" aria-labelledby="fc-dom-80">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-80" class="fc-daygrid-day-number"
                                      aria-label="February 6, 2025">6</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-future fc-day-other"
                                data-date="2025-02-07" aria-labelledby="fc-dom-82">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-82" class="fc-daygrid-day-number"
                                      aria-label="February 7, 2025">7</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                              <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-future fc-day-other"
                                data-date="2025-02-08" aria-labelledby="fc-dom-84">
                                <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                  <div class="fc-daygrid-day-top"><a id="fc-dom-84" class="fc-daygrid-day-number"
                                      aria-label="February 8, 2025">8</a></div>
                                  <div class="fc-daygrid-day-events">
                                    <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                  </div>
                                  <div class="fc-daygrid-day-bg"></div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</div>
@endsection
