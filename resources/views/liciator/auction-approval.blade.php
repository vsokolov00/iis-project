@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>{{ $title }}</h1>
		<table class="table table-striped table-display-lg ">
			<thead>
				<tr>
					<th scope="col">Název</th>
					<th scope="col">Typ aukce</th>
					<th scope="col">Začátek aukce</th>
                    <th scope="col">Konec aukce</th>
					<th scope="col" class="text-right">Počáteční cena</th>
                    <th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($auctions as $auction)
                    <tr data-toggle="collapse" data-target="#detail-{{ $auction->id }}" id="header-{{$auction->id}}">
                        <td class="table-item">{{$auction->auctionItem->item_name}}</td>
                        <td class="table-item">
                            @if($auction->is_selling)
                                <div class="auctionTypeLabel label-yellow">Prodej</div>
                            @else
                                <div class="auctionTypeLabel label-green">Nákup</div>
                            @endif
                        </td>
                        <td class="table-item">
                            @if($auction->start_time < now())
                                <font color="red">
                            @endif

                                {{date("j. n. Y H:i", strtotime($auction->start_time))}}

                            @if($auction->start_time < now())
                                </font>
                            @endif
                        </td>
                        <td class="table-item">
                           @if($auction->start_time < now())
                                <font color="red">
                            @endif

                                {{date("j. n. Y H:i", strtotime($auction->time_limit))}}

                            @if($auction->start_time < now())
                                </font>
                            @endif
                        </td>
                        <td class="text-right table-item">
                            {{number_format($auction->starting_price,0,"", " ")}} Kč
                        </td>
                        <td style="padding-right: 0; text-align: right;" class="table-item">
                            @if($auction->is_approved)
                                <span type="submit" class="material-icons-outlined md-24 mr-3 invalidate dont-propagate clickable" style="height: 24px; width: 24px;" onclick="invalidateAuction('<?=route('invalidateAuction')?>', '{{$auction->id}}')">close</span>
                            @else
                                <span class="clickable material-icons-outlined green-text md-24 pl-4 pr-3 text-right dont-propagate clickable" style="height: 24px;" onclick="openModal('{{ $auction->id }}',
                                    '{{ route('image.displayImage',$auction->auctionItem->image) }}', '{{ $auction->auctionItem->item_name }}', `{{ $auction->auctionItem->description }}`,
                                    '{{ $auction->starting_price }}', '{{ $auction->closing_price }}', '{{ $auction->is_approved }}', '{{ $auction->bid_min }}', '{{ $auction->bid_max }}', '{{ $auction->start_time }}', '{{ $auction->time_limit }}', '{{ $auction->is_open  }}', '{{ $auction->is_selling }}')">edit</span>
                            @endif
                        </td>
                    </tr>

                    <tr class="no-hover-shadow">
                        <td colspan="6" class="pt-0 pb-0">
							<div class="accordian-body collapse" id="detail-{{ $auction->id }}">
                                <div class="mt-4 mb-4">
                                        @csrf
                                        <div class="d-md-flex align-items-center flex-lg-row my-1">
                                            <div class="col">
                                                <div class="d-flex justify-content-center align-items-end p-2">
                                                    <img id="detail-previewImg" src="{{ route('image.displayImage',$auction->auctionItem->image) }}" class="previewImg img-fluid"/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <h3><?= $auction->auctionItem->item_name ?></h3>
                                                <br>
                                                <h5><?= $auction->auctionItem->auctionOwner->name ?></h5>
                                                <br>
                                                <?= $auction->auctionItem->description ?>
                                            </div>
                                        </div>
                                        <div class="d-md-flex flex-lg-row mt-5">
                                            <div class="col">
                                                <h5>Počáteční cena</h5>
                                                <b class="ml-2"><?= $auction->starting_price ?> Kč</b>
                                            </div>
                                            <div class="col">
                                                <h5>Rozsah příhozů</h5>
                                                <b class="d-flex ml-2">
                                                    <?= $auction->bid_min ?> Kč - <?= $auction->bid_max ?> Kč
                                                </b>
                                            </div>
                                        </div>

                                        <div class="d-md-flex flex-lg-row mt-3">
                                            <div class="col">
                                                <h5>Začátek aukce</h5>
                                                <b class="ml-2">
                                                    @if($auction->start_time < now())
                                                        <font color="red">
                                                    @endif

                                                        {{date("j. n. Y H:i", strtotime($auction->start_time))}}

                                                    @if($auction->start_time < now())
                                                        </font>
                                                    @endif
                                                </b>
                                            </div>
                                            <div class="col">
                                                <h5>Konec aukce</h5>
                                                <b class="ml-2">
                                                    @if($auction->start_time < now())
                                                        <font color="red">
                                                    @endif

                                                        {{date("j. n. Y H:i", strtotime($auction->time_limit))}}

                                                    @if($auction->start_time < now())
                                                        </font>
                                                    @endif
                                                </b>
                                            </div>
                                        </div>

                                        <div class="d-md-flex flex-lg-row mt-3 mb-5">
                                            <div class="col">
                                                <h5>Typ aukce</h5>
                                                @if($auction->is_selling)
                                                    <b class="auctionTypeLabel label-yellow ml-2">Prodej</b>
                                                @else
                                                    <b class="auctionTypeLabel label-green ml-2">Nákup</b>
                                                @endif
                                            </div>
                                            <div class="col">
                                                <h5>Pravidla aukce</h5>
                                                @if($auction->is_open)
                                                    <b class="auctionTypeLabel label-yellow ml-2">Otevřená</b>
                                                @else
                                                    <b class="auctionTypeLabel label-green ml-2">Uzavřená</b>
                                                @endif
                                            </div>
                                        </div>
                                        @isset($newParticipants)
                                        @if(!$auction->results_approved)
                                            <div class="table-responsive">
                                                <table  class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Uživatel</th>
                                                            <th>Datum přihlášení</th>
                                                            <th>Příhoz</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr></tr>
                                                        @foreach($newParticipants as $participant)
                                                        @if($auction->id == $participant->auction)
                                                            <tr>
                                                                <td class="align-middle">{{ $participant->user->name }}</td>
                                                                <td class="align-middle">{{ $participant->registered_at }}</td>
                                                                <td class="align-middle">{{ $participant->last_bid }} Kč</td>
                                                                <td class="align-middle text-right">
                                                                    <label for="removeUser{{$auction->id}}{{$participant->user->id}}" class="m-0 invalidate decline-user" data-toggle="tooltip" data-placement="left" title="Odebrat účastníka z aukce">
                                                                        <span class="material-icons md-24 align-middle">person_remove</span>
                                                                    </label>
                                                                    <input class="approve-decline-user d-none" id="removeUser{{$auction->id}}{{$participant->user->id}}" data-username="{{ $participant->user->name }}" data-userid="{{ $participant->user->id }}" data-auctionid = "{{ $auction->id }}" type="submit">
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        @endif
                                        @endisset($newParticipants)
                                        @if(!$auction->is_approved)
                                            @if(Auth::user()->is_admin() || Auth::user()->id !=  $auction->auctionItem->owner)
                                            <div class="m-3 mt-5 d-flex">
                                                <form method="POST">
                                                    @csrf
                                                    <input type="number" name="auctionId" value="{{ $auction->id }}" hidden>
                                                    <input type="number" name="approved" value="0" hidden>
                                                    <button type="submit" class="btn btn-danger m-2" data-dismiss="modal">Zamítnout</button>
                                                </form>
                                                <form method="POST">
                                                    @csrf
                                                    <input type="number" name="auctionId" value="{{ $auction->id }}" hidden>
                                                    <input type="number" name="approved" value="1" hidden>
                                                    <button type="submit" class="btn btn-success m-2">Potvrdit</button>
                                                </form>
                                            </div>
                                            @else
                                                <b> Nemůžete schválit svoji aukci</b>
                                            @endif
                                        @elseif(is_null($auction->results_approved) && now() > $auction->time_limit)
                                        <div id="auction-result">
                                            @if(!is_null($winners[$auction->id][0]))
                                            <!--Get winner name and final price if exist-->
                                             <p style="color: green">Winner je {{ $winners[$auction->id][0]->user->name }} </p>
                                             <p style="color: green">Konečná cena: {{ $winners[$auction->id][1] }} Kč </p>
                                            @else
                                            <p>Nikdo nepříhodil</p>
                                            @endif
                                        </div>
                                        <div>
                                            <input class="auction-result-submit" type="submit" value="Schvalit výsledek" data-auctionid="{{ $auction->id }}" data-response="1" data-target="{{ route('approveAuction') }}">
                                            <input class="auction-result-submit" type="submit" value="Zamitnout výsledek" data-auctionid="{{ $auction->id }}" data-response="0" data-target="{{ route('approveAuction') }}">
                                        </div>
                                        @endif
                                        @if($auction->results_approved && isset($winners))
                                            <p style="color: green">Výsledky aukce jsou již schvalené!</p>
                                            @if(!is_null($winners[$auction->id][0]))
                                            <!--Get winner name and final price if exist-->
                                             <p style="color: green">Winner je {{ $winners[$auction->id][0]->user->name }} </p>
                                             <p style="color: green">Konečná cena: {{ $winners[$auction->id][1] }} Kč </p>
                                            @else
                                            <p>Není winner</p>
                                            @endif
                                        @endif
                                </div>
                            </div>
                        </td>
                    </tr>
				@endforeach
				</tbody>
			</table>

			<table class="table table-striped table-display-sm" >
				<tbody>
					@foreach ($auctions as $auction)
                        <tr data-toggle="collapse" class="#header-small-{{ $auction->id }}" data-target="#detail-small-{{ $auction->id }}">
                            <td>
                                <table class="table-plain">
                                    <tbody>
                                        <tr>
                                        <th scope="row">Název</th>
                                        <td>{{$auction->auctionItem->item_name}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Typ aukce</th>
                                            <td>
                                                @if($auction->is_selling)
                                                    <div class="auctionTypeLabel label-yellow">Prodej</div>
                                                @else
                                                    <div class="auctionTypeLabel label-green">Nákup</div>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Začátek aukce</th>
                                            <td>
                                                @if($auction->start_time < now())
                                                    <font color="red">
                                                @endif

                                                    {{date("j. n. Y H:i", strtotime($auction->start_time))}}

                                                @if($auction->start_time < now())
                                                    </font>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Konec aukce</th>
                                            <td>
                                                @if($auction->start_time < now())
                                                    <font color="red">
                                                @endif

                                                    {{date("j. n. Y H:i", strtotime($auction->time_limit))}}

                                                @if($auction->start_time < now())
                                                    </font>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Počáteční cena</th>
                                            <td>{{number_format($auction->starting_price,0,"", " ")}} Kč</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3 mb-3">
                                    <button type="button" class="btn dont-propagate {{ $auction->is_approved ? 'btn-danger' : 'btn-success'}}"
                                        @if($auction->is_approved)
                                            onclick="invalidateAuction('<?=route('invalidateAuction')?>', '{{$auction->id}}')"
                                        @else
                                            onclick="openModal('{{ $auction->id }}', '{{ route('image.displayImage',$auction->auctionItem->image) }}', '{{ $auction->auctionItem->item_name }}', `{{ $auction->auctionItem->description }}`, '{{ $auction->starting_price }}',
                                            '{{ $auction->closing_price }}', '{{ $auction->is_approved }}', '{{ $auction->bid_min }}', '{{ $auction->bid_max }}', '{{ $auction->start_time }}', '{{ $auction->time_limit }}', '{{ $auction->is_open  }}', '{{ $auction->is_selling }}')"
                                        @endif
                                        >
                                        <div class="d-flex align-content-center">
                                            @if($auction->is_approved)
                                                <span type="submit" class="material-icons-outlined md-24 mr-3" style="height: 24px; width: 24px;" onclick="invalidateAuction('<?=route('invalidateAuction')?>', '{{$auction->id}}')">close</span>
                                                Zrušit schválení
                                            @else
                                                <span class="material-icons-outlined md-24 mr-3 text-right" style="height: 24px; width: 24px; margin-left: -5px;">edit</span>
                                                Editovat
                                            @endif
                                        </div>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="no-hover-shadow">
                            <td colspan="6" class="pt-0 pb-0">
                                <div class="accordian-body collapse" id="detail-small-{{ $auction->id }}">
                                    <div class="mt-4 mb-4">
                                            @csrf
                                            <div class="d-flex justify-content-center align-items-end p-2 mb-4">
                                                <img id="detail-previewImg" src="{{ route('image.displayImage',$auction->auctionItem->image) }}" class="previewImg img-fluid"/>
                                            </div>
                                            <h3><?= $auction->auctionItem->item_name ?></h3>
                                            <br>
                                            <h5><?= $auction->auctionItem->auctionOwner->name ?></h5>
                                            <br>
                                            <?= $auction->auctionItem->description ?>

                                            <div class="d-flex flex-lg-row mt-5">
                                                <div class="col">
                                                    <b>Počáteční cena</b>
                                                </div>

                                                <div class="col">
                                                    <?= $auction->starting_price ?> Kč
                                                </div>
                                            </div>

                                            <div class="d-flex flex-lg-row mt-2">
                                                <div class="col">
                                                        <b>Rozsah příhozů</b>
                                                </div>
                                                <div class="col">10 Kč - 12 Kč</div>
                                            </div>

                                            <div class="d-flex flex-lg-row mt-4">
                                                <div class="col">
                                                    <b>Začátek aukce</b>
                                                </div>
                                                <div class="col">
                                                    @if($auction->start_time < now())
                                                        <font color="red">
                                                    @endif
                                                        {{date("j. n. Y H:i", strtotime($auction->start_time))}}

                                                    @if($auction->start_time < now())
                                                        </font>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="d-flex flex-lg-row mt-2">
                                                <div class="col">
                                                    <b>Konec aukce</b>
                                                </div>
                                                <div class="col">
                                                    @if($auction->start_time < now())
                                                        <font color="red">
                                                    @endif

                                                        {{date("j. n. Y H:i", strtotime($auction->time_limit))}}

                                                    @if($auction->start_time < now())
                                                        </font>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="d-flex flex-lg-row mt-4">
                                                <div class="col">
                                                    <b>Typ aukce</b>
                                                </div>
                                                <div class="col">
                                                    @if($auction->is_selling)
                                                        <div class="auctionTypeLabel label-yellow ml-2">Prodej</div>
                                                    @else
                                                        <div class="auctionTypeLabel label-green ml-2">Nákup</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="d-flex flex-lg-row mt-2">
                                                <div class="col">
                                                    <b>Pravidla aukce</b>
                                                </div>
                                                <div class="col">
                                                    @if($auction->is_open)
                                                        <div class="auctionTypeLabel label-yellow ml-2">Otevřená</div>
                                                    @else
                                                        <div class="auctionTypeLabel label-green ml-2">Uzavřená</div>
                                                    @endif
                                                </div>
                                            </div>
                                            @isset($newParticipants)
                                                @if(!$auction->results_approved)
                                                    <div class="table-responsive mt-3">
                                                        <table style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="2">Registrovaní uživatelé</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr></tr>
                                                        @foreach($newParticipants as $participant)
                                                            @if($auction->id == $participant->auction)
                                                                <tr>
                                                                    <td>
                                                                <table  class="table-plain" style="width:100%">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th>Uživatel</th>
                                                                            <td class="align-middle">{{ $participant->user->name }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Datum přihlášení</th>
                                                                            <td class="align-middle"> {{date("j. n. Y H:i", strtotime($participant->registered_at))}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Příhoz</th>
                                                                            <td class="align-middle">{{ $participant->last_bid }} Kč</td>
                                                                        </tr>
                                                                        <tr>

                                                                            <td colspan="2" class="align-middle text-right">
                                                                                <label for="removeUserMob{{$auction->id}}{{$participant->user->id}}" class="m-0 invalidate">
                                                                                    <span class="material-icons md-24 align-middle">person_remove</span>
                                                                                </label>
                                                                                <input class="approve-decline-user d-none" id="removeUserMob{{$auction->id}}{{$participant->user->id}}" data-username="{{ $participant->user->name }}" data-userid="{{ $participant->user->id }}" data-auctionid = "{{ $auction->id }}" type="submit">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            @endisset($newParticipants)
                                            @if(!$auction->is_approved)
                                                @if(Auth::user()->is_admin() || Auth::user()->id !=  $auction->auctionItem->owner)
                                                <div class="m-3 mt-5 d-flex justify-content-center">
                                                    <form method="POST">
                                                        @csrf
                                                        <input type="number" name="auctionId" value="{{ $auction->id }}" hidden>
                                                        <input type="number" name="approved" value="0" hidden>
                                                        <button type="submit" class="btn btn-danger m-2" data-dismiss="modal">Zamítnout</button>
                                                    </form>
                                                    <form method="POST">
                                                        @csrf
                                                        <input type="number" name="auctionId" value="{{ $auction->id }}" hidden>
                                                        <input type="number" name="approved" value="1" hidden>
                                                        <button type="submit" class="btn btn-success m-2">Potvrdit</button>
                                                    </form>
                                                </div>
                                                @else
                                                    <b> Nemůžete schválit svoji aukci</b>
                                                @endif
                                            @elseif(!$auction->results_approved)
                                                <button>Schvalit vysledek</button>
                                            @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
					@endforeach
			</tbody>
		</table>
	</div>
    @component('components/edit-auction')
    @endcomponent
@endsection
