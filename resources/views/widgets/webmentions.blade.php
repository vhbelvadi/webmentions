<div class="h-full card p-0">
    <header class="flex justify-between items-center p-4 border-b dark:bg-dark-650 dark:border-b dark:border-dark-900">
        <div class="flex gap-2">
            <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="text-gray-800 dark:text-dark-200" stroke="currentColor" stroke-width="1.15" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg> -->
            <svg id="Star-Messages--Streamline-Atlas" class="text-gray-800 dark:text-dark-200" xmlns="http://www.w3.org/2000/svg" viewBox="-0.5 -0.5 24 24" height="24" width="24"><desc>Star Messages Streamline Icon: https://streamlinehq.com</desc><defs></defs><path d="m14.240833333333333 8.36625 0.8529166666666668 1.81125 1.8975 0.2875 -1.3704166666666666 1.40875 0.31625000000000003 1.98375 -1.69625 -0.9391666666666667 -1.69625 0.9391666666666667 0.32583333333333336 -1.98375L11.5 10.465l1.8975 -0.2875 0.8433333333333334 -1.81125z" fill="currentColor" stroke-width="1"></path><path d="M21.5625 9.631250000000001v10.0625l-2.7408333333333332 -2.7504166666666667h-8.232083333333334a3.65125 3.65125 0 0 1 -3.545833333333334 -2.7408333333333332 3.612916666666667 3.612916666666667 0 0 1 -0.115 -0.9583333333333334v-3.612916666666667a3.660833333333333 3.660833333333333 0 0 1 3.660833333333333 -3.660833333333333h7.312083333333334a3.660833333333333 3.660833333333333 0 0 1 3.660833333333333 3.660833333333333Z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="1"></path><path d="M16.07125 5.050416666666666v0.9583333333333334h-5.4816666666666665a3.660833333333333 3.660833333333333 0 0 0 -3.660833333333333 3.660833333333333v2.7408333333333332H4.178333333333334L1.4375 15.112916666666667V5.050416666666666a3.660833333333333 3.660833333333333 0 0 1 3.660833333333333 -3.660833333333333H12.458333333333334a3.660833333333333 3.660833333333333 0 0 1 3.612916666666667 3.660833333333333Z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="1"></path></svg>
            <h2>Recent webmentions</h2>
        </div>
        <!-- If the latest webmention is less than 3 days old say 'New' -->
        @if ( time() - strtotime( $mentions[0]->get_date()) < 259200 )
            <strong class="text-blue uppercase">New</strong>
        @endif
    </header>
    @if ( $mentions )
        <table class="data-table">
            <tbody tabindex="0">
                @foreach ($mentions as $mention)
                    <tr class="sortable-row outline-none">
                        <td>
                            <div class="flex items-center justify-between gap-2">
                                <span class="flex flex-col items-start justify-start inline flex-wrap">
                                    <a class="text-sm block" href="{{ explode(' ', $mention->get_description())[0] }}" target="_blank">
                                        <strong>
                                            @foreach (explode(' ', $mention->get_title()) as $key => $strip)
                                                @if ($key+1 < count(explode(' ', $mention->get_title())))
                                                    {!! $strip !!}
                                                @endif
                                            @endforeach
                                        </strong> <span class="opacity-50">({{ Statamic::modify($mention->get_date())->relative() }})</span>
                                    </a>
                                    <statamic:collection
                                        from="*"
                                        slug:is="{{ explode('/', $mention->get_description())[array_key_last(explode('/', $mention->get_description()))] }}"
                                    >
                                        <a class="text-sm block" href="{{ $url }}" target="_blank">
                                            {{ $title }}
                                        </a>
                                    </statamic:collection>
                                </span>
                                <div class="flex flex-col items-center w-10">
                                    <a class="text-sm group" href="{{ explode(' ', $mention->get_description())[0] }}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="opacity-25 group-hover:opacity-100 min-w-sm" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.15" stroke-linecap="round" stroke-linejoin="round"><g fill="none" fill-rule="evenodd"><path d="M18 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8c0-1.1.9-2 2-2h5M15 3h6v6M10 14L20.2 3.8"/></g></svg>
                                    </a>
                                    <statamic:collection
                                        from="*"
                                        slug:is="{{ explode('/', $mention->get_description())[array_key_last(explode('/', $mention->get_description()))] }}"
                                    >
                                    <a class="text-sm group" href="{{ $edit_url }}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="opacity-25 group-hover:opacity-100 min-w-sm" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.15" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg>
                                    </a>
                                    </statamic:collection>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="px-2 pb-2">
            No webmentions found just yet.
        </p>
    @endif
</div>