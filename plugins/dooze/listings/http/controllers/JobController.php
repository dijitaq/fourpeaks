<?php namespace Dooze\Listings\Http\Controllers;

use Illuminate\Routing\Controller;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Dooze\Listings\Models\Listing;

class JobController extends Controller
{
	protected $token;

	protected $month_arr = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

	public function __construct()
    {
    }

    public function update()
    {
    	$client = new Client(); //GuzzleHttp\Client
        
        $login = $client->request('GET', 'https://api.rexsoftware.com/rex.php', [
				'query' => [
		    			'method' => 'Authentication::login',
		    			'args' => [
			    			"email" => "firdausriyanto@gmail.com",
                            "password" => "firDaus&3Mw",
                            "application" => "rex"
		    			],
		    		],
			]);
        
		$login_xml = json_decode($login->getBody(), true);
        $this->token = $login_xml['result'];
        
		$res = $client->request('GET', 'https://api.rexsoftware.com/rex.php', [
				'query' => [
		    			'method' => 'PublishedListings::search',
		    			'args' => [
			    			'extra_options' => [
				    			'extra_fields' => [
					    			'events', 'images', 'floorplans', 'advert_internet'	
				    			],	
			    			],
			    			'result_format' => 'default',
							'limit' =>  100,
							'order_by' => [
								'system_ctime' => 'desc'
							],
		    			],
		    			'token' => $this->token,
		    		],
			]);
		
		$listing_xml = json_decode($res->getBody(), true);
		//print_r($listing_xml['result']['rows'], true);
		$dump = [];

		$updated_arr = [];
		$added_arr = [];
		$removed_arr = [];

		if (Listing::all()->isNotEmpty())
		{
			foreach($listing_xml['result']['rows'] as $listing)
			{
				print_r( $listing['floorplans'], true );

				$existing = Listing::where('rex_id', $listing['_id'])->first();

				if ($existing)
				{
					if ($listing['system_listing_state'] == "current") {
						// coordinate
						$coordinate_arr = [];

						array_push($coordinate_arr, [ "latitude" => $listing['address']['latitude'] ]);
						array_push($coordinate_arr, [ "longitude" => $listing['address']['longitude'] ]);

						$on_offer = 0;
	
						if ($listing['under_contract'] == "1") {
							$on_offer = 1;
						}

						// category id
						$category_arr = explode("_", $listing['listing_category_id']);
						$category_id = $category_arr[1];
						//print($listing['listing_category_id'] . "\n");
	
						// facilities
						$attributes_arr = [];
	
						array_push($attributes_arr, [ "bedrooms" => $listing['attributes']['bedrooms'] ]);
						array_push($attributes_arr, [ "bathrooms" => $listing['attributes']['bathrooms'] ]);
						array_push($attributes_arr, [ "total_car_accom" => $listing['attributes']['total_car_accom'] ]);
						array_push($attributes_arr, [ "landarea" => substr($listing['attributes']['landarea'], 0, -3) . $listing['attributes']['landarea_unit'] ]);
	
						// events
						$events_arr = [];
	
						if (!empty($listing['events']))
						{
							foreach ($listing['events'] as $event)
							{
								$e_arr = [];
	
								array_push($e_arr, [ "display" => $event['event_type_display'] ]);
	
								$d = substr($event['event_date'], -2);
								
								if (substr($d, 0, 1) == "0")
								{
									$day = substr($d, -1);
	
								} else
								{
									$day = $d;
								}
	
								$m = substr($event['event_date'], -5, 2);
	
								if (substr($m, 0, 1) == "0")
								{
									(int)$m = substr($m, -1);
								}
	
								$month = $this->month_arr[$m - 1];
	
								$year = substr($event['event_date'], 0, 4);
	
								array_push($e_arr, [ "event_date" => $month . " " . $day . " " . $year]);
	
								$hour = substr($event['event_time_start'], 0, 2);
								
								$minute = substr($event['event_time_start'], 3, 2);
	
								array_push($e_arr, [ "event_time" => $hour . ":" . $minute ]);
	
								$time =  mktime((int)$hour, (int)$minute, 0, $m, (int)$day, (int)$year);
	
								array_push($e_arr, [ "event_unix_time" => $time ]);
	
								array_push($events_arr, $e_arr);
							}
						}
	
						// gallery images
						$gallery_images_arr = [];
	
						if (!empty($listing['images']))
						{
							foreach($listing['images'] as $image)
							{
								array_push($gallery_images_arr, [ "type" => "images", "thumb" => basename($image['thumbs']['800x600']), "url" => basename($image['url']) ]);
								//print_r( $image['thumbs']['800x600'] );
							}
						}

						$gallery_floorplans_arr = [];
	
						if (!empty($listing['floorplans']))
						{
							foreach($listing['floorplans'] as $image)
							{
								array_push($gallery_floorplans_arr, [ "type" => "floorplans", "thumb" => basename($image['thumbs']['800x600']), "url" => basename($image['url']) ]);
							}
						}
	
						// body text
						$body_text = "";
	
						if ($listing['advert_internet']['heading'])
						{
							$body_text .= "<p class=\"lead\">" . $listing['advert_internet']['heading'] . "</p>";
						}
	
						$text_arr = explode("\n", $listing['advert_internet']['body']);
						
						foreach($text_arr as $text)
						{
							$body_text .= "<p>" . $text . "</p>";
						}

						// agents
						$agents_arr = [];

						array_push($agents_arr, [ "name" => $listing['listing_agent_1']['name'], 'phone' => $listing['listing_agent_1']['phone_mobile'], 'email' => $listing['listing_agent_1']['email_address'], "image" => $listing['listing_agent_1']['profile_image']['thumbs']['200x250'] ]);
						array_push($agents_arr, [ "name" => $listing['listing_agent_2']['name'], 'phone' => $listing['listing_agent_2']['phone_mobile'], 'email' => $listing['listing_agent_2']['email_address'], "image" => $listing['listing_agent_2']['profile_image']['thumbs']['200x250'] ]);
						
						Listing::find($existing->id)->update([ 'address' => $listing['address']['formats']['street_name_number'] ]);
						Listing::find($existing->id)->update([ 'suburb' => $listing['address']['suburb_or_town'] ]);
						Listing::find($existing->id)->update([ 'coordinate' => $coordinate_arr ]);
						Listing::find($existing->id)->update([ 'slug' => str_slug($listing['address']['formats']['street_name_number'] . "-" . $listing['address']['suburb_or_town'], "-") ]);
						Listing::find($existing->id)->update([ 'category_id' => $category_id ]);
						Listing::find($existing->id)->update([ 'price' => $listing['price_advertise_as'] ]);
						Listing::find($existing->id)->update([ 'on_offer' => $on_offer ]);
						Listing::find($existing->id)->update([ 'facilities' => $attributes_arr ]);
						Listing::find($existing->id)->update([ 'events' => $events_arr ]);
						Listing::find($existing->id)->update([ 'poster_image' => 'images/' . $gallery_images_arr[0]['url'] ]);
						Listing::find($existing->id)->update([ 'gallery_images' => array_merge($gallery_images_arr, $gallery_floorplans_arr) ]);
						Listing::find($existing->id)->update([ 'description' => $body_text ]);
						Listing::find($existing->id)->update([ 'ctime' => (int)$listing['system_publication_timestamp'] ]);
						Listing::find($existing->id)->update([ 'agents' => $agents_arr ]);

						array_push($updated_arr, $listing['address']['formats']['street_name_number']);
						
					} else {
						Listing::find($existing->id)->delete();
						
						array_push($removed_arr, $listing['address']['formats']['street_name_number']);
					}

				} else
				{
					// add new
					if ($listing['system_listing_state'] == "current") {
						$l = new Listing;
						$l->ctime = (int)$listing['system_publication_timestamp'];
						$l->rex_id = $listing['_id'];
						$l->address = $listing['address']['formats']['street_name_number'];
						$l->suburb = $listing['address']['suburb_or_town'];
						$l->slug = str_slug($listing['address']['formats']['street_name_number'] . "-" . $listing['address']['suburb_or_town'], "-");
						$l->price = $listing['price_advertise_as'];

						// coordinate
						$coordinate_arr = [];

						array_push($coordinate_arr, [ "latitude" => $listing['address']['latitude'] ]);
						array_push($coordinate_arr, [ "longitude" => $listing['address']['longitude'] ]);

						$l->coordinate = $coordinate_arr;
						
						// category id
						$category_arr = explode("_", $listing['listing_category_id']);
						$l->category_id = $category_arr[1];
						//print($listing['listing_category_id'] . "\n");

						if ($listing['under_contract'] == "1") {
							$l->on_offer = 1;
	
						} else {
							$l->on_offer = 0;
						}
	
						// facilities
						$attributes_arr = [];
	
						array_push($attributes_arr, [ "bedrooms" => $listing['attributes']['bedrooms'] ]);
						array_push($attributes_arr, [ "bathrooms" => $listing['attributes']['bathrooms'] ]);
						array_push($attributes_arr, [ "total_car_accom" => $listing['attributes']['total_car_accom'] ]);
						array_push($attributes_arr, [ "landarea" => substr($listing['attributes']['landarea'], 0, -3) . $listing['attributes']['landarea_unit'] ]);

						$l->facilities = $attributes_arr;
	
						// events
						$events_arr = [];
	
						if (!empty($listing['events']))
						{
							foreach ($listing['events'] as $event)
							{
								$e_arr = [];
	
								array_push($e_arr, [ "display" => $event['event_type_display'] ]);
								//array_push($events_arr, [ "date" => $listing['events']['event_date'] ]);
								$d = substr($event['event_date'], -2);
								
								if (substr($d, 0, 1) == "0") {
									$day = substr($d, -1);
	
								} else
								{
									$day = $d;
								}
	
								$m = substr($event['event_date'], -5, 2);
	
								if (substr($m, 0, 1) == "0") {
									(int)$m = substr($m, -1);
								}
	
								$month = $this->month_arr[$m - 1];
	
								$year = substr($event['event_date'], 0, 4);
	
								array_push($e_arr, [ "event_date" => $month . " " . $day . " " . $year]);
	
								$hour = substr($event['event_time_start'], 0, 2);
								
								$minute = substr($event['event_time_start'], 3, 2);
	
								array_push($e_arr, [ "event_time" => $hour . ":" . $minute ]);
	
								$time =  mktime((int)$hour, (int)$minute, 0, $m, (int)$day, (int)$year);
	
								array_push($e_arr, [ "event_unix_time" => $time ]);
	
								array_push($events_arr, $e_arr);
							}
	
							$l->events = $events_arr;
						}
	
						// gallery images
						$gallery_images_arr = [];
	
						if (!empty($listing['images']))
						{
							foreach($listing['images'] as $image)
							{
								array_push($gallery_images_arr, [ "type" => "images", "thumb" => basename($image['thumbs']['800x600']), "url" => basename($image['url']) ]);
								//print_r( $image['thumbs']['800x600'] );
							}
	
							$l->poster_image = 'images/' . $gallery_images_arr[0]['url'];
	
							$l->image_path = substr($image['url'], 0, strlen($image['url']) - strlen(basename($image['url']) . "/images"));
						}

						$gallery_floorplans_arr = [];
	
						if (!empty($listing['floorplans']))
						{
							foreach($listing['floorplans'] as $image)
							{
								array_push($gallery_floorplans_arr, [ "type" => "floorplans", "thumb" => basename($image['thumbs']['800x600']), "url" => basename($image['url']) ]);
							}
						}

						$l->gallery_images = array_merge( $gallery_images_arr, $gallery_floorplans_arr);
	
						// body text
						$body_text = "";
	
						if ($listing['advert_internet']['heading'])
						{
							$body_text .= "<p class=\"lead\">" . $listing['advert_internet']['heading'] . "</p>";
						}
	
						$text_arr = explode("\n", $listing['advert_internet']['body']);
				
						foreach($text_arr as $text)
						{
							$body_text .= "<p>" . $text . "</p>";
						}
	
						$l->description = $body_text;

						// agents
						$agents_arr = [];

						array_push($agents_arr, [ "name" => $listing['listing_agent_1']['name'], 'phone' => $listing['listing_agent_1']['phone_mobile'], 'email' => $listing['listing_agent_1']['email_address'], "image" => $listing['listing_agent_1']['profile_image']['thumbs']['200x250'] ]);
						array_push($agents_arr, [ "name" => $listing['listing_agent_2']['name'], 'phone' => $listing['listing_agent_2']['phone_mobile'], 'email' => $listing['listing_agent_2']['email_address'], "image" => $listing['listing_agent_2']['profile_image']['thumbs']['200x250'] ]);

						$l->agents = $agents_arr;
	
						$l->save();
	
						array_push($added_arr, $listing['address']['formats']['street_name_number']);
					}
				}
			}

		} else
		{
			// populate database
			foreach($listing_xml['result']['rows'] as $listing)
			{
				//echo "[" . $listing['address']['formats']['street_name_number'] . "--" . $listing['system_listing_state'] . "]\r\n";

				if ($listing['system_listing_state'] == "current") {
					$l = new Listing;
					$l->ctime = (int)$listing['system_publication_timestamp'];
					$l->rex_id = $listing['_id'];
					$l->address = $listing['address']['formats']['street_name_number'];
					$l->suburb = $listing['address']['suburb_or_town'];
					$l->slug = str_slug($listing['address']['formats']['street_name_number'] . "-" . $listing['address']['suburb_or_town'], "-");
					$l->price = $listing['price_advertise_as'];

					// coordinate
					$coordinate_arr = [];

					array_push($coordinate_arr, [ "latitude" => $listing['address']['latitude'] ]);
					array_push($coordinate_arr, [ "longitude" => $listing['address']['longitude'] ]);

					$l->coordinate = $coordinate_arr;

					// category id
					$category_arr = explode("_", $listing['listing_category_id']);
					$l->category_id = $category_arr[1];
					//print($listing['listing_category_id'] . "\n");
	
					if ($listing['under_contract'] == "1") {
						$l->on_offer = 1;
	
					} else {
						$l->on_offer = 0;
					}
	
					// facilities
					$attributes_arr = [];
	
					array_push($attributes_arr, [ "bedrooms" => $listing['attributes']['bedrooms'] ]);
					array_push($attributes_arr, [ "bathrooms" => $listing['attributes']['bathrooms'] ]);
					array_push($attributes_arr, [ "total_car_accom" => $listing['attributes']['total_car_accom'] ]);
					array_push($attributes_arr, [ "landarea" => substr($listing['attributes']['landarea'], 0, -3) . $listing['attributes']['landarea_unit'] ]);
					$l->facilities = $attributes_arr;
	
					// events
					$events_arr = [];
	
					if (!empty($listing['events']))
					{
						foreach ($listing['events'] as $event) {
							$e_arr = [];
	
							array_push($e_arr, [ "display" => $event['event_type_display'] ]);
							//array_push($events_arr, [ "date" => $listing['events']['event_date'] ]);
							$d = substr($event['event_date'], -2);
							
							if (substr($d, 0, 1) == "0") {
								$day = substr($d, -1);
	
							} else
							{
								$day = $d;
							}
	
							$m = substr($event['event_date'], -5, 2);
	
							if (substr($m, 0, 1) == "0") {
								(int)$m = substr($m, -1);
							}
	
							$month = $this->month_arr[$m - 1];
	
							$year = substr($event['event_date'], 0, 4);
	
							array_push($e_arr, [ "event_date" => $month . " " . $day . " " . $year]);
	
							$hour = substr($event['event_time_start'], 0, 2);
							
							$minute = substr($event['event_time_start'], 3, 2);
	
							array_push($e_arr, [ "event_time" => $hour . ":" . $minute ]);
	
							$time =  mktime((int)$hour, (int)$minute, 0, $m, (int)$day, (int)$year);
	
							array_push($e_arr, [ "event_unix_time" => $time ]);
	
							array_push($events_arr, $e_arr);
						}
	
						$l->events = $events_arr;
					}
	
					// gallery images
					$gallery_images_arr = [];
	
					if (!empty($listing['images']))
					{
						foreach($listing['images'] as $image)
						{
							array_push($gallery_images_arr, [ "type" => "images", "thumb" => basename($image['thumbs']['800x600']), "url" => basename($image['url']) ]);
							//print_r( $image['thumbs']['800x600'] );
						}
	
						$l->poster_image = 'images/' . $gallery_images_arr[0]['url'];
	
						$l->image_path = substr($image['url'], 0, strlen($image['url']) - strlen(basename($image['url']) . "/images"));
					}

					$gallery_floorplans_arr = [];
	
					if (!empty($listing['floorplans']))
					{
						foreach($listing['floorplans'] as $image)
						{
							array_push($gallery_floorplans_arr, [ "type" => "floorplans", "thumb" => basename($image['thumbs']['800x600']), "url" => basename($image['url']) ]);
						}
					}

					$l->gallery_images = array_merge( $gallery_images_arr, $gallery_floorplans_arr);
	
					// body text
					$body_text = "";
	
					if ($listing['advert_internet']['heading'])
					{
						$body_text .= "<p class=\"lead\">" . $listing['advert_internet']['heading'] . "</p>";
					}
	
					$text_arr = explode("\n", $listing['advert_internet']['body']);
					
					foreach($text_arr as $text)
					{
						$body_text .= "<p>" . $text . "</p>";
					}
	
					$l->description = $body_text;

					// agents
					$agents_arr = [];

					array_push($agents_arr, [ "name" => $listing['listing_agent_1']['name'], 'phone' => $listing['listing_agent_1']['phone_mobile'], 'email' => $listing['listing_agent_1']['email_address'], "image" => $listing['listing_agent_1']['profile_image']['thumbs']['200x250'] ]);
					array_push($agents_arr, [ "name" => $listing['listing_agent_2']['name'], 'phone' => $listing['listing_agent_2']['phone_mobile'], 'email' => $listing['listing_agent_2']['email_address'], "image" => $listing['listing_agent_2']['profile_image']['thumbs']['200x250'] ]);

					$l->agents = $agents_arr;
	
					$l->save();
	
					array_push($added_arr, $listing['address']['formats']['street_name_number']);
				}
			}
		}

		return view('dooze.listings::updates', [ 'num_records' => count($listing_xml['result']['rows']), 'updated_arr' => $updated_arr, 'added_arr' => $added_arr, 'removed_arr' => $removed_arr, 'dump' => $dump ]);
    }
}