<!DOCTYPE html>
<html>
<head>
    <title>{{ $heading1 }}</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Calibri, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3, h4, h5 {
            margin: 0;
            padding: 0 0 5px 0;
        }

        h1 {
            font-size: 21px;
            color: #00257f;
            font-weight: normal;
            padding: 20px 20px 0 20px;
            background-color: #efefef;
            margin-bottom: 0;
        }

        h2 {
            font-size: 18px;
            color: #00257f;
            font-weight: normal;
        }

        h3 {
            font-size: 12px;
        }

        h4 {
            font-size: 14px;
            padding: 0 20px 20px;
            background-color: #efefef;
            margin-bottom: 10px;
            font-weight: bold;
        }

        h5 {
            font-size: 10px;
        }

        .turquoise {
            color: #14b1cc !important;
        }

        .fa-asterisk {
            font-weight: bold;
            font-size: 24px;
        }

        .index-table {
            margin-top: 10px;
            font-size: 10px;
            width: 100%;
        }

        .index-table tr > td {
            /*border-left: 1px solid #e6e6e6;*/
            vertical-align: middle;
            border-bottom: 1px solid #ccd3e5;
        }

        .index-table tbody tr > td:first-of-type {
            background-color: #ccd3e5;
            border-bottom: 0;
        }

        .index-table tr > td.content-center {
            text-align: center;
        }

        .index-table tr > td.content-right {
            text-align: right;
        }

        .index-table tr > td:last-child {
            border-right: 1px solid #e6e6e6;
        }

        .index-table thead tr > td {
            background-color: #00257f;
            color: white;
            border-collapse: separate;
            font-weight: bold;
        }

        .index-table thead tr > td.sub-header {
            background-color: #dee0e6;
            color: #5F697F;
        }

        .index-table tr > td {
            padding: 5px 10px;
        }

        .index-table tbody tr > td.actions, .index-table tbody tr > td.archive-count, .index-table tbody tr > td.client-links {
            padding: 5px;
            width: 1%;
            white-space: nowrap;
        }

        .index-table tbody tr > td.archive-count, .index-table tbody tr > td.client-links {
            padding-right: 10px;
            border-left: 0 !important;
            color: #5F697F;
        }

        .index-table tbody tr > td .event-log-icon {
            padding-right: 10px;
        }

        .index-table tbody tr > td { }

        .index-table button {
            line-height: 1;
        }

        .index-table .status-active {
            background-color: #d5ff95;
            color: green;
        }

        .index-table .status-dormant {
            color: #d3d3d3;
        }

        .index-table thead, .index-table tfoot {
            display: table-row-group;
        }

        .index-table tr td, .index-table tr th {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
@yield('content')
</body>
</html>