@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex jumbotron justify-content-center flex-column bg-white">
            <h2>Online aukční portál pro věci všeho druhu.<br>Každá věc má u nás svou hodnotu!</h2>

            <div class="d-flex flex-md-nowrap flex-wrap justify-content-start flex-row">
                <a class="btn btn-warning nav-link m-2 col-xs-2" href="{{ route('newAuction') }}" role="button">
                    <div class="d-flex justify-content-center">
                        Vytvořit aukci
                    </div>
                </a>
            </div>
        </div>
    </div>
	<div class="background-grey pt-5 pb-5">
			<div class="container">
					<div class="d-flex justify-content-center py-3">
							<h1 class="">Aukční informační systém</h1>
					</div>
					<div>
							<h2 class="mr-auto">Nejbližší aukce</h2>
							<div class="d-flex align-items-stretch mainPage-auction-list-container">
									<div class = "align-items-center list-arrow-left hidesLeft">
											<div class="material-icons-outlined md-48" id="newAuctionLeft" onclick="leftScroll('#newAuctionList')">
													arrow_back_ios
											</div>
									</div>
									<div class="d-flex mainPage-auctionv -list" id="newAuctionList">
										@foreach ($auctions as $auction)
											<div class="mainPage-auction">
													@if (file_exists('storage/images/'.$auction->auctionItem->image) and $auction->auctionItem->image)
														<img class="img-fluid" src="{{ asset('storage/images/'.$auction->auctionItem->image) }}" alt="Položka aukce"/>
													@else
														<img class="img-fluid" src="{{ url('/') }}/assets/default_image.png" alt="Položka aukce"/>
													@endif
													<h4>{{ $auction->auctionItem->item_name }}</h4>
													<div class="mainPage-offer">
														@if ($auction->is_selling)
															Nabídka
														@else
															Poptávka
														@endif
													</div>
													<h3>{{ $auction->starting_price + $bids[$auction->id] }} Kč</h3>
													<span>Začátek: {{ $auction->start_time }}</span>
													<a href="{{ route('auctionDetail', ['id' => "$auction->id"]) }}">Podrobneji</a>
											</div>
										@endforeach
									</div>
									<div class = "d-flex align-items-center list-arrow-right hidesRight">
											<div class="list-arrow" id="newAuctionRight" onclick="rightScroll('#newAuctionList')">
													<span class="material-icons-outlined md-48">arrow_forward_ios</span>
											</div>
									</div>
							</div>
					</div>
					<div>
							<h2>Oblíbené aukce</h2>
							<div class="d-flex align-items-stretch mainPage-auction-list-container">
									<div class = "align-items-center list-arrow-left hidesLeft">
											<div class="material-icons-outlined md-48" id="newAuctionLeft" onclick="leftScroll('#favouriteAuctionList')">
													arrow_back_ios
											</div>
									</div>
									<div class="d-flex mainPage-auction-list" id="favouriteAuctionList">
											<?php for($i=0; $i < 6; $i++){
													echo '

															<div class="mainPage-auction">
																	<img class="img-fluid" src="./img/vaza.jpg" alt="Položka aukce"/>
																	<h4>Malovaná váza</h4>
																	<div class="mainPage-offer">Nabídka</div>
																	<h3>5000Kč</h3>
																	<span>Začátek: 10.11.2021 13:30</span>
															</div>
													';
											}?>
									</div>
									<div class = "d-flex align-items-center list-arrow-right hidesRight">
											<div class="list-arrow" id="newAuctionRight" onclick="rightScroll('#favouriteAuctionList')">
													<span class="material-icons-outlined md-48">arrow_forward_ios</span>
											</div>
									</div>
							</div>
					</div>
			</div>
	</div>
@endsection
