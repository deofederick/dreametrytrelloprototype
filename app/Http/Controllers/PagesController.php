<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Ixudra\Curl\Facades\Curl;
use Auth;
use App\boardList;
use App\Board;

class PagesController extends Controller
{

    
    public function index(){

        
        if(Auth::guest()){
            return view('pages.index');
        }else{

            $idUser = auth()->user()->trelloId;
            $key = auth()->user()->apikey;
            $token = auth()->user()->apitoken;
            //  \Log::info($idUser);
            $url = 'https://api.trello.com/1/members/'.$idUser.'/boards?key='.$key.'&token='.$token.'&fields=id,name,url,memberships&lists=open';
            $response = Curl::to($url)->get();
            $boards = json_decode($response, TRUE);
            
            $totalOwnedCard = 0;
            $totalL1 = 0;
            $totalL2 = 0;
            $totalL3 = 0;
            $totalL4 = 0;
            $totalL5 = 0;
            $totalCards = 0;
            $totalUnAssigned = 0;

            $DataL1 = [];
            $DataL2 = [];
            $DataL3 = [];
            $DataL4 = [];
            $DataL5 = [];
            $DataNoLabel = [];

            foreach ($boards as $board) {
                foreach ($board['memberships'] as $member) {
                    if ($idUser == $member['idMember']) {
                        $boardArray[] = [$board['name'], $board['id']];
                        $listUrl = "https://api.trello.com/1/boards/".$board['id']."/lists?key=".$key."&token=".$token."&cards=none&filter=open";
                        $listresponse = Curl::to($listUrl)->get();
                        $lists = json_decode($listresponse, TRUE);
                        // \Log::info($board['name']);
                        foreach ($lists as $list) {
                            $cardsUrl = "https://api.trello.com/1/lists/".$list['id']."/cards?key=".$key."&token=".$token."&fields=name,desc,idMembers,shortUrl,labels,actions,idList";
                            $cardsResponse = Curl::to($cardsUrl)->get();
                            $cards = json_decode($cardsResponse, TRUE);
                            $totalCards += count($cards);
                        
                            foreach ($cards as $card) {
                                if (count($card['idMembers']) > 0) {
                                    for ($i=0; $i < count($card['idMembers']) ; $i++) { 
                                        if ($idUser === $card['idMembers'][$i]) {
                                            $totalOwnedCard++;
                                        //    \Log::info($card);
                                            
                                            if (count($card['labels']) > 0) {
                                                for ($p=0; $p < count($card['labels']) ; $p++) { 
                                                    //  \Log::info($card['labels'][$p]['name']);
                                                    switch ($card['labels'][$p]['name']) {
                                                        case 'L1':
                                                            $DataL1[] = array(
                                                                'cardname' => $card['name'],
                                                                'cardUrl' => $card['shortUrl'],
                                                                'board' => $board['name']
                                                            );
                                                            break;
                                                        case 'L2':
                                                            $DataL2[] = array(
                                                                'cardname' => $card['name'],
                                                                'cardUrl' => $card['shortUrl'],
                                                                'board' => $board['name']
                                                            );
                                                            break;
                                                        case 'L3':
                                                            $DataL3[] = array(
                                                                'cardname' => $card['name'],
                                                                'cardUrl' => $card['shortUrl'],
                                                                'board' => $board['name']
                                                            );
                                                            break;
                                                        case 'L4':
                                                            $DataL4[] = array(
                                                                'cardname' => $card['name'],
                                                                'cardUrl' => $card['shortUrl'],
                                                                'board' => $board['name']
                                                            );
                                                            break;
                                                        case 'L5':
                                                            $DataL5[] = array(
                                                                'cardname' => $card['name'],
                                                                'cardUrl' => $card['shortUrl'],
                                                                'board' => $board['name']
                                                            );
                                                            break;
                                                            
                                                    }
                                                }
                                            }else{
                                                $DataNoLabel[] = array(
                                                    'cardname' => $card['name'],
                                                    'cardUrl' => $card['shortUrl'],
                                                    'board' => $board['name']
                                                );
                                            
                                            }

                                        }
                                    }
                                }else{
                                    $totalUnAssigned++;
                                }
                                
                                
                            }
                            
                        }
                    }
                }
            }
         //     \Log::info($DataNoLabel);
            $data = array(
                'owned' => $totalOwnedCard,
                'totalcards' => $totalCards,
                'l1cards' => $DataL1,
                'l2cards' => $DataL2,
                'l3cards' => $DataL3,
                'l4cards' => $DataL4,
                'l5cards' => $DataL5,
                'nolabel' => $DataNoLabel,
                'unassigned' => $totalUnAssigned

            );
            
            //  \Log::info($data);

            return view('pages.index')->with($data);

        }
        

    }

    public function taskload(){
        if(Auth::guest()){
            return view('pages.index');
        }else{

            $idUser = auth()->user()->trelloId;
            $key = auth()->user()->apikey;
            $token = auth()->user()->apitoken;
            //  \Log::info($idUser);
            $boards = Board::all();
            
            $DataL1 = [];
            $DataL2 = [];
            $DataL3 = [];
            $DataL4 = [];
            $DataL5 = [];
            $DataNoLabel = [];

            foreach ($boards as $board) {
                $listUrl = "https://api.trello.com/1/boards/".$board['board_id']."/lists?key=".$key."&token=".$token."&cards=none&filter=open";
                $listresponse = Curl::to($listUrl)->get();
                $lists = json_decode($listresponse, TRUE);
                // \Log::info($board['name']);
                foreach ($lists as $list) {
                    $cardsUrl = "https://api.trello.com/1/lists/".$list['id']."/cards?key=".$key."&token=".$token."&fields=name,desc,idMembers,shortUrl,labels,actions,idList";
                    $cardsResponse = Curl::to($cardsUrl)->get();
                    $cards = json_decode($cardsResponse, TRUE);
                   // \Log::info($cards);
                     /* 
                    $DataL1[] = array(
                        'cardname' => $card['name'],
                        'cardUrl' => $card['shortUrl'],
                        'status' => $list->status->status_name
                    );
                    */

                    
                    foreach ($cards as $card) {

                        if (count($card['idMembers']) > 0) {

                            $list = boardList::where('list_id', $card['idList'])->first();
                           /*  if (count($list)) {
                                \Log::info($list->status->status_name." - ".$card['name']);
                            }else{
                                \Log::info("Not in Progress"." - ".$card['name']);
                            }
                            
                            */ 
                            \Log::info(count($card['labels']));
                            if (count($card['labels']) > 0) {
                                for ($p=0; $p < count($card['labels']) ; $p++) { 
                                    //  \Log::info($card['labels'][$p]['name']);
                                    if (count($list)) {
                                        \Log::info($list->status->status_name." - ".$card['name']." - ".$card['labels'][$p]['name']);
                                        
                                    }else{
                                        \Log::info("Not in Progress"." - ".$card['name']." - ".$card['labels'][$p]['name']);
                                    }

                                    switch ($card['labels'][$p]['name']) {
                                        case 'L1':
                                            if (count($list)) {
                                                $DataL1[] = array(
                                                    'cardname' => $card['name'],
                                                    'cardUrl' => $card['shortUrl'],
                                                    'status' => $list->status->status_name
                                                );
                                            }else{
                                                $DataL1[] = array(
                                                    'cardname' => $card['name'],
                                                    'cardUrl' => $card['shortUrl'],
                                                    'status' => "Not in Progress"
                                                );
                                            }
                                            break;
                                        case 'L2':
                                            if (count($list)) {
                                                $DataL2[] = array(
                                                    'cardname' => $card['name'],
                                                    'cardUrl' => $card['shortUrl'],
                                                    'status' => $list->status->status_name
                                                );
                                            }else{
                                                $DataL2[] = array(
                                                    'cardname' => $card['name'],
                                                    'cardUrl' => $card['shortUrl'],
                                                    'status' => "Not in Progress"
                                                );
                                            }
                                            break;
                                        case 'L3':
                                            if (count($list)) {
                                                $DataL3[] = array(
                                                    'cardname' => $card['name'],
                                                    'cardUrl' => $card['shortUrl'],
                                                    'status' => $list->status->status_name
                                                );
                                            }else{
                                                $DataL3[] = array(
                                                    'cardname' => $card['name'],
                                                    'cardUrl' => $card['shortUrl'],
                                                    'status' => "Not in Progress"
                                                );
                                            }
                                            break;
                                        case 'L4':
                                            if (count($list)) {
                                                $DataL4[] = array(
                                                    'cardname' => $card['name'],
                                                    'cardUrl' => $card['shortUrl'],
                                                    'status' => $list->status->status_name
                                                );
                                            }else{
                                                $DataL4[] = array(
                                                    'cardname' => $card['name'],
                                                    'cardUrl' => $card['shortUrl'],
                                                    'status' => "Not in Progress"
                                                );
                                            }
                                            break;
                                        case 'L5':
                                            if (count($list)) {
                                                $DataL5[] = array(
                                                    'cardname' => $card['name'],
                                                    'cardUrl' => $card['shortUrl'],
                                                    'status' => $list->status->status_name
                                                );
                                            }else{
                                                $DataL5[] = array(
                                                    'cardname' => $card['name'],
                                                    'cardUrl' => $card['shortUrl'],
                                                    'status' => "Not in Progress"
                                                );
                                            }
                                            break;
                                            
                                    }
                                }
                            }else{

                                if (count($list)) {
                                    $DataNoLabel[] = array(
                                        'cardname' => $card['name'],
                                        'cardUrl' => $card['shortUrl'],
                                        'status' => $list->status->status_name
                                    );
                                } else {
                                    $DataNoLabel[] = array(
                                        'cardname' => $card['name'],
                                        'cardUrl' => $card['shortUrl'],
                                        'status' => "Not in Progress"
                                    );
                                }
                                
                            }
                            /* for ($i=0; $i < count($card['idMembers']) ; $i++) { 
                                if ($idUser === $card['idMembers'][$i]) {
                                    if (count($card['labels']) > 0) {
                                        for ($p=0; $p < count($card['labels']) ; $p++) { 
                                            //  \Log::info($card['labels'][$p]['name']);
                                            switch ($card['labels'][$p]['name']) {
                                                case 'L1':
                                                    if (count($list)) {
                                                        $DataL1[] = array(
                                                            'cardname' => $card['name'],
                                                            'cardUrl' => $card['shortUrl'],
                                                            'status' => $list->status->status_name
                                                        );
                                                    }else{
                                                        $DataL1[] = array(
                                                            'cardname' => $card['name'],
                                                            'cardUrl' => $card['shortUrl'],
                                                            'status' => "Not in Progress"
                                                        );
                                                    }
                                                    break;
                                                case 'L2':
                                                    if (count($list)) {
                                                        $DataL2[] = array(
                                                            'cardname' => $card['name'],
                                                            'cardUrl' => $card['shortUrl'],
                                                            'status' => $list->status->status_name
                                                        );
                                                    }else{
                                                        $DataL2[] = array(
                                                            'cardname' => $card['name'],
                                                            'cardUrl' => $card['shortUrl'],
                                                            'status' => "Not in Progress"
                                                        );
                                                    }
                                                    break;
                                                case 'L3':
                                                    if (count($list)) {
                                                        $DataL3[] = array(
                                                            'cardname' => $card['name'],
                                                            'cardUrl' => $card['shortUrl'],
                                                            'status' => $list->status->status_name
                                                        );
                                                    }else{
                                                        $DataL3[] = array(
                                                            'cardname' => $card['name'],
                                                            'cardUrl' => $card['shortUrl'],
                                                            'status' => "Not in Progress"
                                                        );
                                                    }
                                                    break;
                                                case 'L4':
                                                    if (count($list)) {
                                                        $DataL4[] = array(
                                                            'cardname' => $card['name'],
                                                            'cardUrl' => $card['shortUrl'],
                                                            'status' => $list->status->status_name
                                                        );
                                                    }else{
                                                        $DataL4[] = array(
                                                            'cardname' => $card['name'],
                                                            'cardUrl' => $card['shortUrl'],
                                                            'status' => "Not in Progress"
                                                        );
                                                    }
                                                    break;
                                                case 'L5':
                                                    if (count($list)) {
                                                        $DataL5[] = array(
                                                            'cardname' => $card['name'],
                                                            'cardUrl' => $card['shortUrl'],
                                                            'status' => $list->status->status_name
                                                        );
                                                    }else{
                                                        $DataL5[] = array(
                                                            'cardname' => $card['name'],
                                                            'cardUrl' => $card['shortUrl'],
                                                            'status' => "Not in Progress"
                                                        );
                                                    }
                                                    break;
                                                    
                                            }
                                        }
                                    }else{

                                        if (count($list)) {
                                            $DataNoLabel[] = array(
                                                'cardname' => $card['name'],
                                                'cardUrl' => $card['shortUrl'],
                                                'status' => $list->status->status_name
                                            );
                                        } else {
                                            $DataNoLabel[] = array(
                                                'cardname' => $card['name'],
                                                'cardUrl' => $card['shortUrl'],
                                                'status' => "Not in Progress"
                                            );
                                        }
                                        
                                    }

                                }
                            } */
                        }
                        
                        
                    }
                    
                }
            }
         //     \Log::info($DataNoLabel);
            $data = array(
                'l1cards' => $DataL1,
                'l2cards' => $DataL2,
                'l3cards' => $DataL3,
                'l4cards' => $DataL4,
                'l5cards' => $DataL5,
                'nolabel' => $DataNoLabel

            );
            
            //  \Log::info($data);

            return $data;

        }
    }

    public function task(){

        $id = auth()->user()->trelloId;
        $key = auth()->user()->apikey;
        $token = auth()->user()->apitoken;
        $lists = boardList::all();
        //\Log::info($lists);
        $todo = 0;
        $rev = 0;
        $done = 0;
        $paid = 0;
        $unreglist = 0;
        foreach ($lists as $list) {
            
            $url = 'https://api.trello.com/1/lists/'.$list->list_id.'/cards?key='.$key.'&token='.$token;
          
            $response = Curl::to($url)->get();
           // \Log::info($list->status->status_name);
           
            $trellolists = json_decode($response, TRUE);
            //\Log::info($trellolists);

            $status = $list->status->status_name;
            // \Log::info($status." - ".count($trellolists));
          
            switch ($status) {
                case 'To Do':
                    foreach ($trellolists as $member) {
                        foreach ($member['idMembers'] as $idMember) {
                            $todo += ($idMember == $id) ? 1 : 0 ;
                        }
                    }


                   // $todo += count($trellolists);
                    break;
                
                case 'For Review':
                    foreach ($trellolists as $member) {
                        foreach ($member['idMembers'] as $idMember) {
                            $rev += ($idMember == $id) ? 1 : 0 ;
                        }
                    }

                   // $rev += count($trellolists);
                    break;
                
                case 'Done':
                    foreach ($trellolists as $member) {
                        foreach ($member['idMembers'] as $idMember) {
                            $done += ($idMember == $id) ? 1 : 0 ;
                        }
                    }

                    //$done += count($trellolists);
                    break;

                case 'Paid':
                    foreach ($trellolists as $member) {
                        foreach ($member['idMembers'] as $idMember) {
                            $paid += ($idMember == $id) ? 1 : 0 ;
                        }
                    }

                   // $paid += count($trellolists);
                    break;

                case '':
                    foreach ($trellolists as $member) {
                        foreach ($member['idMembers'] as $idMember) {
                            $unreglist += ($idMember == $id) ? 1 : 0 ;
                        }
                    }

                   // $unreglist += count($trellolists);
                    break;
            }

            $data = array(
                // 'boards' => $boardArray,
                 
                 'todo' => $todo,
                 'rev' => $rev,
                 'done' => $done,
                 'paid' => $paid,
                 'unreglist' => $unreglist
    
             );
        }

        \Log::info($data);
        
        $var = 0;
         return view('pages.task')->with($data);

       // return view('pages.task')->with('variable', $var);
       
    }
}
