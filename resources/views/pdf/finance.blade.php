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
      width: 100%;
      min-height: 100vh;
      position: relative;
      padding: 3rem;
    }

    table {
      border: 1px solid black;
      border-collapse: collapse;
      margin: 30px 0;
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
        /* flex-direction: column; */
    }

    .text-underline {
      text-decoration: underline;
    }

    .ml-5 {
      margin-left: 50px;
    }

    .mt-5 {
      margin-top: 80px;
    }

    footer {
      width: 100%;
      margin-top: 100px;
    }
  </style>
  <title>Address</title>
</head>

<body>
  @php
    $total = 0;
  @endphp

  <header>
    <h1>
      <div>Project {{ $data[0]->project_name }}</div>
      <div>Periode {{ now()->toFormattedDateString() }}</div>
    </h1>
  </header>

  <main>
    <table>
      <thead>
        <tr>
          <th>Nama Pengendara</th>
          <th>BBM</th>
          <th>Toll</th>
          <th>Parkir</th>
          <th>Un/Load</th>
          <th>Maint</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $activity)
          @php
            $subTotal = $activity->total_bbm + $activity->total_toll + $activity->total_park + $activity->total_maintenance + $activity->total_load + $activity->total_unload;
            $total += $subTotal;
          @endphp
          <tr>
            <td>{{ $activity->person_name }}</td>
            <td>@money($activity->total_bbm)</td>
            <td>@money($activity->total_toll)</td>
            <td>@money($activity->total_park)</td>
            <td>@money($activity->total_load + $activity->total_unload)</td>
            <td>@money($activity->total_maintenance)</td>
            <td>
              @money($subTotal)
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="summary">
      <strong>Total Pengeluaran:</strong> @money($total)
    </div>
  </main>

  <footer>
    <div class="sign">
      <div class="sign__box">
        <div>Prepared by</div>
        <div class="mt-5 text-underline">Astri Dya</div>
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

</body>

</html>
