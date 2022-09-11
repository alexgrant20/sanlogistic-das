<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .text-primary {
      color: red;
    }
  </style>
  <title>Address</title>
</head>

<body>
  <header>
    {{-- <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/IMG_logo_%282017%29.svg" alt="Default image" height="75px"> --}}
    <h1 class="text-primary">Addresses</h1>
  </header>

  <main>
    <table>
      <thead>
        <tr>
          <th>id</th>
          <th>Address Name</th>
          <th>Full Address</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $address)
          <tr>
            <td>{{ $address->address_id }}</td>
            <td>{{ $address->address_name }}</td>
            <td>{{ $address->full_address }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </main>

</body>

</html>
