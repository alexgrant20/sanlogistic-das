<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    h1 {
      text-transform: uppercase;
      font-size: 1.2rem;
    }

    body {
      width: 100vw;
      min-height: 100vh;
      position: relative;
      padding: 3rem;
      font-size: 9px;
    }

    table {
      border: 1px solid black;
      border-collapse: collapse;
      margin: 15px 0;
      width: 100%;
    }

    th,
    tr,
    td {
      border: 1px solid black;
    }

    th,
    td {
      padding: 2px 5px;
    }

    .sign {
      display: flex;
      width: 100%;
    }

    .sign__box {
      display: inline-block;
      text-align: center
    }

    .text-underline {
      text-decoration: underline;
    }

    .ml-5 {
      margin-left: 100px;
    }

    .mt-5 {
      margin-top: 40px;
    }

    .mb-2 {
      margin-bottom: 20px;
    }

    .mb-1 {
      margin-bottom: 10px;
    }

    footer {
      width: 100%;
      margin-top: 100px;
    }

    main {
      width: 100%;
    }

    .fs-md {
      font-size: 13px;
    }

    .fs-sm {
      font-size: 10px;
    }

    .text-end {
      text-align: right;
    }

    .fw-bold {
      font-weight: bold
    }
  </style>
  <title>Activity Submission</title>
</head>

<body>
  @php
    $total = 0;
  @endphp

  @foreach ($groupedByMonth as $month => $data)
  <header>
  <h1>
      <div>Project {{ $projectName }}</div>
      <div>Periode {{ now()->toFormattedDateString() }}</div>
  </h1>
  </header>

  <main class="mt-5">
  
      @php
        $activityDescriptions = [];
      @endphp


      <h2>Periode Bulan {{ $month }}</h2>
      <h3>Pengiriman {{ $data['min_date'] }} - {{ $data['max_date'] }} </h3>
      <table>
        <thead>
          <tr>
            <th style="width: 25%">Nama Pengendara</th>
            <th style="width: 10%">BBM</th>
            <th style="width: 10%">Toll</th>
            <th style="width: 10%">Park</th>
            <th style="width: 10%">Courier</th>
            <th style="width: 10%">Un/Load</th>
            <th style="width: 10%">Maintenance</th>
            <th style="width: 15%">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data['activitiesGroupedByUser'] as $personName => $activity)
            @php
              if ($activity->get('description')->isNotEmpty()) {
                  $activityDescriptions[$personName] = $activity->get('description');
              }
              $totalPerPerson = $activity->get('total_bbm') + $activity->get('total_toll') + $activity->get('total_park') + $activity->get('total_maintenance') + $activity->get('total_load_unload') + $activity->get('total_courier');
            @endphp
            <tr>
              <td>{{ $personName }}</td>
              <td class="text-end">@money($activity->get('total_bbm'))</td>
              <td class="text-end">@money($activity->get('total_toll'))</td>
              <td class="text-end">@money($activity->get('total_park'))</td>
              <td class="text-end">@money($activity->get('total_courier'))</td>
              <td class="text-end">@money($activity->get('total_load_unload'))</td>
              <td class="text-end">@money($activity->get('total_maintenance'))</td>
              <td class="text-end">
                @money($totalPerPerson)
              </td>
            </tr>
          @endforeach
          <tr>
            <td>Total</td>
            <td class="text-end">@money($subtotal[$month]['subtotal_bbm'])</td>
            <td class="text-end">@money($subtotal[$month]['subtotal_toll'])</td>
            <td class="text-end">@money($subtotal[$month]['subtotal_park'])</td>
            <td class="text-end">@money($subtotal[$month]['subtotal_courier'])</td>
            <td class="text-end">@money($subtotal[$month]['subtotal_load_unload'])</td>
            <td class="text-end">@money($subtotal[$month]['subtotal_maintenance'])</td>
            <td class="text-end">@money($summaryTotal[$month])</td>
          </tr>
        </tbody>
      </table>

      @if (count($activityDescriptions) > 0)
        <h3 class="mb-1">Catatan untuk periode ini</h3>
        @foreach ($activityDescriptions as $personName => $descriptions)
          <div class="mb-2">
            <p class="fw-bold fs-sm">{{ $personName }}</p>
            <ul>
              @foreach ($descriptions as $description)
                <li>{{ $description }}</li>
              @endforeach
            </ul>
          </div>
        @endforeach
      @endif
 
    {{--
    <div class="summary">
      <strong>Total Pengeluaran:</strong> @money($total)
    </div> --}}
  </main>

  <footer>
  <div class="sign">
      <div class="sign__box">
        <div>Prepared by</div>
        <div class="mt-5 text-underline">{{ auth()->user()->person->name }}</div>
        <div>Operation</div>
      </div>
      <div class="sign__box ml-5">
        <div>Approved by</div>
        <div class="mt-5 text-underline">Natanael Prasetyo A.</div>
        <div>Head Operation</div>
      </div>
      <div class="sign__box ml-5">
        <div>Checked by</div>
        <div class="mt-5">&nbsp;</div>
        <div>Head Fin & Acc</div>
      </div>
    </div>

  </footer>
  @if($loop->first)
    <div style="page-break-before:always">&nbsp;</div> 
  @endif
 @endforeach
</body>

</html>
