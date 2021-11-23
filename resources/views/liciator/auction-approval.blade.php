@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>Neschválené aukce</h1>
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
                <?php $imagePath = "storage/images/"; ?>
				@foreach ($auctions as $auction)
                    <tr data-toggle="collapse" data-target="#detail-{{ $auction->id }}">
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
                            <span class="material-icons-outlined green-text md-24 pl-4 pr-3 text-right" style="height: 24px;" onclick="openModal('{{ $auction->id }}',
                            '{{ asset($imagePath . $auction->auctionItem->image); }}', '{{ $auction->auctionItem->item_name }}', `{{ $auction->auctionItem->description }}`,
                            '{{ $auction->starting_price }}', '{{ $auction->is_approved }}', '{{ $auction->bid_min }}', '{{ $auction->bid_max }}', '{{ $auction->start_time }}', '{{ $auction->time_limit }}', '{{ $auction->is_open  }}', '{{ $auction->is_selling }}')">edit</span>
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
                                                    <img id="detail-previewImg" src="{{ asset($imagePath . $auction->auctionItem->image); }}" class="previewImg img-fluid"/>
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

                                                        <?= $auction->start_time ?>

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

                                                        <?= $auction->time_limit ?>

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
                        <tr data-toggle="collapse" data-target="#detail-small-{{ $auction->id }}">
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
                                    <button type="button" class="btn btn-success" onclick="openModal('{{ $auction->id }}',
                            '{{ asset($imagePath . $auction->auctionItem->image); }}', '{{ $auction->auctionItem->item_name }}', `{{ $auction->auctionItem->description }}`,
                            '{{ $auction->starting_price }}', '{{ $auction->is_approved }}', '{{ $auction->bid_min }}', '{{ $auction->bid_max }}', '{{ $auction->start_time }}', '{{ $auction->time_limit }}', '{{ $auction->is_open  }}', '{{ $auction->is_selling }}')">
                                        <div class="d-flex align-content-center">
                                            <span class="material-icons-outlined md-24 mr-3 text-right" style="height: 24px; width: 24px; margin-left: -5px;">edit</span>
                                            Editovat
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
                                                <img id="detail-previewImg" src="{{ asset($imagePath . $auction->auctionItem->image); }}" class="previewImg img-fluid"/>
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

                                                        <?= $auction->start_time ?>

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

                                                        <?= $auction->time_limit ?>

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
