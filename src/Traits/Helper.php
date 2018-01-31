<?php

    namespace App\Traits;


    trait Helper
    {
        public static function sanitizeInput($input, $type)
        {
            try
            {
                switch ($type)
                {
                    case 'INT':
                        $input = filter_var($input, FILTER_VALIDATE_INT);
                        $input = filter_var($input, FILTER_SANITIZE_NUMBER_INT);
                        break;

                    case 'STRING':
                        $input = filter_var($input, FILTER_SANITIZE_STRING);
                        break;

                    case 'EMAIL':
                        $input = filter_var($input, FILTER_VALIDATE_EMAIL);
                        break;

                    default:
                        $input = filter_var($input, FILTER_SANITIZE_STRING);
                        break;
                }

                return $input;
            }
            catch(\Exception $e)
            {
                throw $e;
            }
        }

        public static function paginate($targetpage, $page, $limit = 15, $count_results)
        {
            $stages = 3;
            if ($page == 0)
                $page = 1;
            $prev = $page - 1;
            $next = $page + 1;
            $lastpage = ceil($count_results / $limit);
            $LastPagem1 = $lastpage - 1;
            $paginate = '';

            if ($lastpage > 0) {
                $paginate .= '<ul class="pagination ">';
                if ($page > 1) {
                    $paginate .= '<li><a href="' . $targetpage . 'p=1"> <i class="fa fa-angle-double-left"></i> </a></li>';
                    $paginate .= '<li><a href="' . $targetpage . 'p=' . $prev . '"> <i class="fa fa-angle-left"></i> </a></li>';
                }
                else {
                    $paginate .= '<li class="disabled"><span> <i class="fa fa-angle-double-left"></i> </span></li>';
                    $paginate .= '<li class="disabled"><span> <i class="fa fa-angle-left"></i> </span></li>';
                }
                if ($lastpage < 7 + ($stages * 2)) {
                    for ($counter = 1; $counter <= $lastpage; $counter++) {
                        if ($counter == $page) {
                            $paginate .= '<li class="active"><span>' . $counter . '</span></li>';
                        }
                        else {
                            $paginate .= '<li><a href="' . $targetpage . 'p=' . $counter . '"><span>' . $counter . '</span></a></li>';
                        }
                    }
                }
                elseif ($lastpage > 5 + ($stages * 2)) {
                    if ($page < 1 + ($stages * 2)) {
                        for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
                            if ($counter == $page) {
                                $paginate .= '<li class="active"><span>' . $counter . '</span></li>';
                            }
                            else {
                                $paginate .= '<li><a href="' . $targetpage . 'p=' . $counter . '"><span>' . $counter . '</span></a></li>';
                            }
                        }
                        $paginate .= '<li><span>...</span></li>';
                        $paginate .= '<li><a href="' . $targetpage . 'p=' . $LastPagem1 . '">' . $LastPagem1 . '</a></li>';
                        $paginate .= '<li><a href="' . $targetpage . 'p=' . $lastpage . '">' . $lastpage . '</a></li>';
                    }
                    elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
                        $paginate .= '<li><a href="' . $targetpage . 'p=1">1</a></li>';
                        $paginate .= '<li><a href="' . $targetpage . 'p=2">2</a></li>';
                        $paginate .= '<li><span>...</span></li>';
                        for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
                            if ($counter == $page) {
                                $paginate .= '<li class="active"><span>' . $counter . '</span></li>';
                            }
                            else {
                                $paginate .= '<li><a href="' . $targetpage . 'p=' . $counter . '"><span>' . $counter . '</span></a></li>';
                            }
                        }
                        $paginate .= '<li><span>...</span></li>';
                        $paginate .= '<li><a href="' . $targetpage . 'p=' . $LastPagem1 . '">' . $LastPagem1 . '</a></li>';
                        $paginate .= '<li><a href="' . $targetpage . 'p=' . $lastpage . '">' . $lastpage . '</a></li>';
                    }
                    else {
                        $paginate .= '<li><a href="' . $targetpage . 'p=1">1</a></li>';
                        $paginate .= '<li><a href="' . $targetpage . 'p=2">2</a></li>';
                        $paginate .= "<li><span>...</span></li>";
                        for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
                            if ($counter == $page) {
                                $paginate .= '<li class="active"><span class="">' . $counter . '</span></li>';
                            }
                            else {
                                $paginate .= '<li><a href="' . $targetpage . 'p=' . $counter . '"><span>' . $counter . '</span></a></li>';
                            }
                        }
                    }
                }
                if ($page < $counter - 1) {
                    $paginate .= '<li><a href="' . $targetpage . 'p=' . $next . '""> <i class="fa fa-angle-right"></i> </a></li>';
                    $paginate .= '<li><a href="' . $targetpage . 'p=' . $lastpage . '""> <i class="fa fa-angle-double-right"></i> </a></li>';
                }
                else {
                    $paginate .= '<li class="disabled"><span> <i class="fa fa-angle-right"></i> </span></a></li>';
                    $paginate .= '<li class="disabled"><span> <i class="fa fa-angle-double-right"></i> </span></li>';
                }
                $paginate .= '</ul>';
            }

            return $paginate;
        }
    }