<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light" >Work Order</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <div class="form-inline">
        
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @php
                    $menus = DB::table('menus')->select('*')->where('status', 1)->get();
                 
                @endphp
                @foreach ($menus as $item)
                    @if($item->type == 1)
                    <li class="nav-item">
                        <a href="{{$item->link}}" class="nav-link">
                            <i class="nav-icon {{$item->icon}}"></i>
                            <p>{{$item->name}}</p>
                        </a>
                    </li>
                    @else
                        <li class="nav-item">
                            @php
                                $submenus = DB::table('submenus')->where('status', 1)->where('id_menus', $item->id)->get();
                                // dd($submenus);
                            @endphp
                             <a href="#" class="nav-link">
                                <i class="nav-icon {{$item->icon}}"></i>
                                <p>{{$item->name}}<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                            @foreach ($submenus as $row)
                                <li class="nav-item pl-4">
                                    <a href="{{$row->link}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                    <p>{{$row->name}}</p>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>   
                    @endif
                @endforeach
                
             
            </ul>
        </nav>

    </div>

</aside>