
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
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr onclick="openUserModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')">
            <td>{{ $user->name }}</td>
            <td>
              <div class="material-switch pull-right">
              @if($user->is_auctioneer())
                <input class="role" id="{{ $user->id }}rlic"  type="checkbox" name="roleLic" checked/>
              @else
                <input class="role" id="{{ $user->id }}rlic"  type="checkbox" name="roleLic"/>
              @endif  
              <label for="{{ $user->id }}rlic" class="label-green"></label>
              </div>
            </td>
            <td>
              <div class="material-switch pull-right">
              @if($user->is_admin())
                <input class="role" id="{{ $user->id }}radmin" type="checkbox" name="roleAdm" checked/>
              @else
                <input class="role" id="{{ $user->id }}radmin" type="checkbox" name="roleAdm"/>
              @endif
              <label for="{{ $user->id }}radmin" class="label-yellow"></label>
              </div>
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
                            @if($user->is_auctioneer())
                              <input class="mrole" id="{{ $user->id }}rlic"  type="checkbox" name="roleLic" checked/>
                            @else
                              <input class="mrole" id="{{ $user->id }}rlic"  type="checkbox" name="roleLic"/>
                            @endif  
                            <label for="{{ $user->id }}rlic" class="label-green"></label>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Administrátor</th>
                        <td>
                            <div class="material-switch pull-right mrole">
                              @if($user->is_admin())
                                <input class="mrole" id="{{ $user->id }}radmin" type="checkbox" name="roleAdm" checked/>
                              @else
                                <input class="mrole" id="{{ $user->id }}radmin" type="checkbox" name="roleAdm"/>
                              @endif
                              <label for="{{ $user->id }}radmin" class="label-yellow"></label>
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

