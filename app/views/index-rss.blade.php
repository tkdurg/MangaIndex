<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
  <channel>
    <title>{{htmlspecialchars( $pageTitle , ENT_QUOTES)}} - Madokami</title>
    <link>{{htmlspecialchars(URL::to('/'), ENT_QUOTES)}}{{htmlspecialchars( $path->getUrl() , ENT_QUOTES)}}?t=rss</link>
    <description>{{htmlspecialchars( $path->getUrl() , ENT_QUOTES)}} - Madokami</description>
    <pubDate>{{htmlspecialchars( (new DateTime(date('Y-m-d H:i:s', $updated)))->format(DateTime::RFC822), ENT_QUOTES)}}</pubDate>

    @foreach($children as $child)@if(!$child->isDir)<item>
      <title>{{htmlspecialchars( $child->name , ENT_QUOTES)}}</title>
      <link>{{htmlspecialchars(URL::to('/'), ENT_QUOTES)}}{{htmlspecialchars( $child->url , ENT_QUOTES)}}</link>
      <enclosure url="{{htmlspecialchars(URL::to('/'), ENT_QUOTES)}}{{htmlspecialchars( $child->url , ENT_QUOTES)}}" type="{{htmlspecialchars($child->mime, ENT_QUOTES)}}" length="{{htmlspecialchars($child->rawSize, ENT_QUOTES)}}" />
      <guid>{{htmlspecialchars(URL::to('/'), ENT_QUOTES)}}{{htmlspecialchars( $child->url , ENT_QUOTES)}}?length={{htmlspecialchars( $child->rawSize , ENT_QUOTES)}}&amp;mtime={{htmlspecialchars( $child->rawTime, ENT_QUOTES)}}</guid>
      <pubDate>{{htmlspecialchars( (new DateTime(date('Y-m-d H:i:s', $child->rawTime)))->format(DateTime::RFC822), ENT_QUOTES)}}</pubDate>
    </item>
    @endif @endforeach
</channel>
</rss>