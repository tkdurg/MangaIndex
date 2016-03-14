<?xml version="1.0" encoding="utf-8"?>
<opml version="1.0">
  <head>
    <title>Madokami Watched Series Export</title>
  </head>
  <body>
    <outline text="Madokami - Watched Series">
      @foreach($watched as $series)
        @foreach($series->pathRecords as $path)
             <outline title="{{{$series->name}}}" type="rss" htmlUrl="{{{URL::to('/')}}}{{{$path->getPath()->getUrl()}}}" xmlUrl="{{{URL::to('/')}}}{{{$path->getPath()->getUrl()}}}?t=rss" />
        @endforeach
      @endforeach
    </outline>
  </body>
</opml>
