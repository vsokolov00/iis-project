
@extends('layouts.app')

@section('content')


<div class="detail-background detail-view-hide" id="detail-background"></div>
  <div class="detail-container d-flex align-items-center justify-content-center detail-view-hide" id="detail-container">
      <div class="detail-form detail-view-hide d-flex flex-column" id="detail-form">
        <a class="ml-auto" onclick="hideDetail()">
          <span class="material-icons-outlined">close</span>
        </a>

        <table class="table-plain">
          <tr>
            <th scope="row">Jméno</th>
            <td id="detailUserName">Matěj Gotzman</td>
          </tr>
          <tr>
            <th id="detailUserEmail" scope="row">Email </th>
            <td>afafd@afdas</td>
          </tr>
        </table>
        <div id="userAuctions" class="detail-list-view"></div>
      </div>

    </div>
    <div class="container">
      <h1>Seznam uživatelů</h1>
      <table class="table table-striped table-display-lg ">
        <thead>
          <tr>
            <th scope="col">Jméno</th>
            <th scope="col">Liciátor</th>
            <th scope="col">Administrátor</th>
            <th scope="col"/>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr onclick="openUserModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')">
            <td class="align-middle">{{ $user->name }}</td>
            <td class="align-middle">
              <div class="material-switch pull-right mt-1">
                <input class="role type-toggle" id="{{ $user->id }}rlic"  type="checkbox" name="roleLic" data-userid="{{ $user->id }}" data-role="auctioneer"
                @if($user->is_auctioneer()) checked @endif />
              <label for="{{ $user->id }}rlic" class="label-green"></label>
              </div>
            </td>
            <td class="align-middle">
              <div class="material-switch pull-right mt-1">
                <input class="role type-toggle" id="{{ $user->id }}radmin" type="checkbox" name="roleAdm" data-userid="{{ $user->id }}" data-role="admin"
                @if($user->is_admin()) checked @endif />
              <label for="{{ $user->id }}radmin" class="label-yellow"></label>
              </div>
            </td>
            <td class="d-flex justify-content-end">
                <form method="POST" class="mb-0">
                    @method('delete')
                    @csrf
                    <input type="text" name="userId" value="{{ $user->id }}" hidden>
                    <button type="submit" class="invalidate dont-propagate deleteUser mr-2">
                        <span class="material-icons md-24 mr-3 clickable">delete</span>
                    </button>
                </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <table class="table table-striped table-display-sm" >
      <tbody>
            @foreach($users as $user)
             <tr onclick="showDetail({{ $user->id }})">
                <td>
                <table class="table-plain">
                <tbody>
                    <tr>
                      <th scope="row">Jméno </th>
                      <td>{{ $user->name }}</td>
                    </tr>
                      <tr>
                        <th scope="row">Liciátor</th>
                        <td>
                            <div class="material-switch pull-right mrole">
                              <input class="mrole type-toggle" id="{{ $user->id }}rlic-m" type="checkbox" name="roleLic" data-userid="{{ $user->id }}" data-role="auctioneer"
                              @if($user->is_auctioneer()) checked @endif />
                            <label for="{{ $user->id }}rlic-m" class="label-green"></label>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Administrátor</th>
                        <td>
                            <div class="material-switch pull-right mrole">
                                <input class="mrole type-toggle" id="{{ $user->id }}radmin-m" type="checkbox" name="roleAdm" data-userid="{{ $user->id }}" data-role="admin"
                                @if($user->is_admin()) checked @endif />
                              <label for="{{ $user->id }}radmin-m" class="label-yellow"></label>
                            </div>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    @component('components/edit-user')
    @endcomponent

@endsection('content')

