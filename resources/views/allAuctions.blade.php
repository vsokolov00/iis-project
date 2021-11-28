@extends('layouts.app')

@section('content')
    <div class="background-grey pt-5 pb-5" style="margin-top:-30px; margin-bottom:-30px">
			<div class="container">
				<h1>{{ $title }}</h1>
				<div class="d-flex flex-wrap align-items-stretch  mainPage-auction-list" id="allAuctionsList">
					@foreach($auctions as $auction)
						<?php $route = route("auctionDetail", ["id" => $auction->id]) ?>
						<div class="allAuctions-item" onclick="window.location='{{$route}}'">
							<div class="img-container d-flex align-items-center justify-content-center">
								<div>
									<img class="img-fluid" src="{{ route('image.displayImage',$auction->auctionItem->image) }}" alt="Položka aukce"/>
								</div>
							</div>
							<h4>{{ $auction->auctionItem->item_name}}</h4>
							@if ($auction->is_selling)
								<div class="mainPage-offer">
									Nabídka
								</div>
							@else
								<div class="mainPage-buy">
									Poptávka
								</div>
							@endif
							@if(isset($bids) && !is_null($bids))
								@if(isset($myWonAuctions))
								<h3>{{ $auction->starting_price + $bids[$auction->id] }} Kč</h3>
								@else
								<h3>{{ $auction->is_open ? $auction->starting_price + $bids[$auction->id] : $auction->starting_price }} Kč</h3>
								@endif
							@else
								<h3>{{ $auction->starting_price }} Kč</h3>
							@endif
							<span>Začátek: {{ $auction->start_time }}</span>
						</div>
					@endforeach
					<!-- divs to fill free space-->
					<div class="allAuctions-item-fill"></div>
					<div class="allAuctions-item-fill"></div>
					<div class="allAuctions-item-fill"></div>
				</div>
			</div>
		</div>
@endsection
