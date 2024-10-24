


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Jazz Connections</title>

    <style>


body, h1, h2 {
    color: #444;
    font-family: 'Helvetica Neue', Helvetica, sans-serif;
    font-weight: 300;
}
#graph {
    float: left;
    position: relative;
}
#notes {
    float: left;
    margin-left: 20px;
}
h1, h2 {
    margin: 0;
}
h1 {
    font-size: 1.4em;
    margin-bottom: 0.2em;
}
h2 {
    font-size: 1.1em;
    margin-bottom: 1em;
}
.artwork img {
    border: 1px solid #fff;
    -webkit-box-shadow: 0 3px 5px rgba(0,0,0,.3);
    -moz-box-shadow: rgba(0,0,0,.3) 0 3px 5px;
    border-color: #a2a2a2    9;
}
ul {
    list-style: none;
    padding-left: 0;
}
li {
    padding-top: 0.2em;
}
.node circle, circle.node {
    cursor:       pointer;
    fill:         #ccc;
    stroke:       #fff;
    stroke-width: 1px;
}
.edge line, line.edge {
    cursor:       pointer;
    stroke:       #aaa;
    stroke-width: 2px;
}
.labelNode text, text.labelNode {
    cursor:       pointer;
    fill:        #444;
    font-size:   11px;
    font-weight: normal;
}
ul.connection {
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    cursor: pointer;
    font-size: 11px;
    font-weight: normal;
    padding: 10px;
    position: absolute;
}
ul.connection:before,
ul.connection:after {
    border: 10px solid transparent;
    content: '';
    position: absolute;
}
ul.connection:before {
    border-bottom-color: #f0f0f0;
    top: -19px;
    left: 20px;
    z-index: 2;
}
ul.connection:after {
    border-bottom-color: rgba(0, 0, 0, 0.2);
    top: -21px;
    left: 20px;
    z-index: 1;
}
/*
ul.connection li {
    background-color: #eee;
    border-left: 1px #444 solid;
    border-right: 1px #444 solid;
    font-size: 11px;
    font-weight: normal;
    margin: 0 50% 0 -50%;
    padding: 2px 4px;
}
ul.connection li:first-child {
    border-top: 1px #444 solid;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}
ul.connection li:last-child {
    border-bottom: 1px #444 solid;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
}
*/
ul.connection.hidden {
    display: none;
}

    </style>
</head>
<body>

	<script src="d3.js"></script>

    <div id='container'>
        <div id='graph'></div>
        <div id='notes'></div>
    </div>
    <script type="text/javascript">

// Define the dimensions of the visualization. We're using
// a size that's convenient for displaying the graphic on
 // http://jsDataV.is

var width = 1000,
    height = 476;

// Visual properties of the graph are next. We need to make
// those that are going to be animated accessible to the
// JavaScript.

var labelFill = '#444';
var adjLabelFill = '#aaa';
var edgeStroke = '#aaa';
var nodeFill = '#ccc';
var nodeRadius = 10;
var selectedNodeRadius = 30;

var linkDistance = Math.min(width,height)/4;

// Find the main graph container.

var graph = d3.select('#graph');

// Create the SVG container for the visualization and
// define its dimensions.

var svg = graph.append('svg')
    .attr('width', width)
    .attr('height', height);

// Select the container for the notes and dimension it.

var notes = d3.select('#notes')
    .style({
        'width': 620-width + 'px',
        'height': height + 'px'
    });

// Utility function to update the position properties
// of an arbtrary edge that's part of a D3 selection.
// The optional parameter is the array of nodes for
// the edges. If present, the source and target properties
// are assumed to be indices in this array rather than
// direct references.

var positionEdge = function(edge, nodes) {
    edge.attr('x1', function(d) {
        return nodes ? nodes[d.source].x : d.source.x;
    }).attr('y1', function(d) {
        return nodes ? nodes[d.source].y : d.source.y;
    }).attr('x2', function(d) {
        return nodes ? nodes[d.target].x : d.target.x;
    }).attr('y2', function(d) {
        return nodes ? nodes[d.target].y : d.target.y;
    });
};

// Utility function to update the position properties
// of an arbitrary node that's part of a D3 selection.

var positionNode = function(node) {
    node.attr('transform', function(d) {
        return 'translate(' + d.x + ',' + d.y + ')';
    });
};

// Utility function to position text associated with
// a label pseudo-node. The optional third parameter
// requests transition to the specified fill color.

var positionLabelText = function(text, pseudonode, fillColor) {

    // What's the width of the text element?

    var textWidth = text.getBBox().width;

    // How far is the pseudo-node from the real one?

    var diffX = pseudonode.x - pseudonode.node.x;
    var diffY = pseudonode.y - pseudonode.node.y;
    var dist = Math.sqrt(diffX * diffX + diffY * diffY);

    // Shift in the x-direction a fraction of the text width

    var shiftX = textWidth * (diffX - dist) / (dist * 2);
    shiftX = Math.max(-textWidth, Math.min(0, shiftX));

    var shiftY = pseudonode.node.selected ? selectedNodeRadius : nodeRadius;
    shiftY = 0.5 * shiftY * diffY/Math.abs(diffY);

    var select = d3.select(text);
    if (fillColor) {
        select = select.transition().style('fill', fillColor);
    }
    select.attr('transform', 'translate(' + shiftX + ',' + shiftY + ')');
};


// Define the data.

data = [
  {
    "artist": "Miles Davis",
    "title": "Kind of Blue",
    "itunes": "https://itunes.apple.com/us/album/kind-of-blue-legacy-edition/id300865074",
    "cover": "http://a4.mzstatic.com/us/r30/Features/v4/7b/f1/43/7bf14346-8e9d-e243-16e1-81f7377699a7/dj.aacpwrsd.170x170-75.jpg",
    "color": "#47738C",
    "text": "#0A0606",
    "musicians": [
      "Cannonball Adderley",
      "Paul Chambers",
      "Jimmy Cobb",
      "John Coltrane",
      "Miles Davis",
      "Bill Evans"
    ]
  },{
    "artist": "John Coltrane",
    "title": "A Love Supreme",
    "itunes": "https://itunes.apple.com/us/album/a-love-supreme-deluxe-edition/id3269858",
    "cover": "http://a5.mzstatic.com/us/r30/Features/v4/b3/67/bf/b367bf8e-4380-e566-de28-2c2bc69ef8ed/V4HttpAssetRepositoryClient-ticket.kvpiloem.jpg-2481435390037859980.170x170-75.jpg",
    "color": "#747C7B",
    "text": "#343437",
    "musicians": [
      "John Coltrane",
      "Jimmy Garrison",
      "Elvin Jones",
      "McCoy Tyner"
    ]
  },{
    "artist": "The Dave Brubeck Quartet",
    "title": "Time Out",
    "itunes": "https://itunes.apple.com/us/album/time-out-50th-anniversary/id316475425",
    "cover": "http://a5.mzstatic.com/us/r30/Music/fc/10/e4/mzi.nxyspvyl.170x170-75.jpg",
    "color": "#42578E",
    "text": "#D57130",
    "musicians": [
      "Dave Brubeck",
      "Paul Desmond",
      "Joe Morello",
      "Eugene Write"
    ]
  },{
    "artist": "Duke Ellington",
    "title": "Ellington at Newport",
    "itunes": "https://itunes.apple.com/us/album/ellington-at-newport-1956/id214466665",
    "cover": "http://a2.mzstatic.com/us/r30/Features/e5/43/3b/dj.kzeqdddm.170x170-75.jpg",
    "color": "#D06B2F",
    "text": "#2F4051",
    "musicians": [
      "Harry Carney",
      "John Willie Cook",
      "Duke Ellington",
      "Paul Gonsalves",
      "Jimmy Grissom",
      "Jimmy Hamilton",
      "Johnny Hodges",
      "Quentin Jackson",
      "William Anderson",
      "Ray Nance",
      "Russell Procope",
      "John Sanders",
      "Clark Terry",
      "James Woode",
      "Britt Woodman",
      "Sam Woodyar"
    ]
  },{
    "artist": "The Quintet",
    "title": "Jazz at Massey Hall",
    "itunes": "https://itunes.apple.com/us/album/quintet-jazz-at-massey-hall/id152035858",
    "cover": "http://a5.mzstatic.com/us/r30/Features/e7/f0/51/dj.suakypmw.170x170-75.jpg",
    "color": "#B03239",
    "text": "#191A18",
    "musicians": [
      "Dizzy Gillespie",
      "Charles Mingus",
      "Charlie Parker",
      "Bud Powell",
      "Max Roach"
    ]
  },{
    "artist": "Louis Armstrong",
    "title": "The Best of the Hot Five and Hot Seven Recordings",
    "itunes": "https://itunes.apple.com/us/album/best-hot-5-hot-7-recordings/id201274363",
    "cover": "http://a2.mzstatic.com/us/r30/Music/54/10/9d/mzi.tzqujtgu.170x170-75.jpg",
    "color": "#B08865",
    "text": "#483830",
    "musicians": [
      "Lil Hardin Armstrong",
      "Louis Armstrong",
      "Clarence Babcock",
      "Pete Briggs",
      "Mancy Carr",
      "Baby Dodds",
      "Johnny Dodds",
      "Earl Hines",
      "Kid Ory",
      "Don Redman",
      "Fred Robinson",
      "Zutty Singleton",
      "Johnny St. Cyr",
      "Jimmy Strong",
      "John Thomas",
      "Dave Wilborn"
    ]
  },{
    "artist": "John Coltrane",
    "title": "Blue Trane",
    "itunes": "https://itunes.apple.com/us/album/blue-train-bonus-track-version/id724748588",
    "cover": "http://a5.mzstatic.com/us/r30/Music4/v4/4f/fe/d8/4ffed84e-8865-22b9-7a8e-ac1eaa07a542/00724359692456.170x170-75.jpg",
    "color": "#0C7F90",
    "text": "#041E1F",
    "musicians": [
      "Paul Chambers",
      "John Coltrane",
      "Kenny Drew",
      "Curtis Fuller",
      "Philly Joe Jones",
      "Lee Morgan"
    ]
  },{
    "artist": "Stan Getz and João Gilberto",
    "title": "Getz/Gilberto",
    "itunes": "https://itunes.apple.com/us/album/getz-gilberto/id485540980",
    "cover": "http://a3.mzstatic.com/us/r30/Features/b2/47/50/dj.qizgqbsb.170x170-75.jpg",
    "color": "#ED8C42",
    "text": "#24231B",
    "musicians": [
      "Milton Banana",
      "Stan Getz",
      "Astrud Gilberto",
      "João Gilberto",
      "Antonio Carlos Jobim",
      "Sebastião Neto"
    ]
  },{
    "artist": "Charles Mingus",
    "title": "Mingus Ah Um",
    "itunes": "https://itunes.apple.com/us/album/mingus-ah-um-legacy-edition/id316476217",
    "cover": "http://a2.mzstatic.com/us/r30/Music/85/f3/ef/mzi.lugdrvxc.170x170-75.jpg",
    "color": "#B07B89",
    "text": "#28282C",
    "musicians": [
      "Willie Dennis",
      "Booker Ervin",
      "Shafi Hadi",
      "John Handy",
      "Jimmy Knepper",
      "Charles Mingus",
      "Horace Parlan",
      "Dannie Richmond"
    ]
  },{
    "artist": "Erroll Garner",
    "title": "Concert by the Sea",
    "itunes": "https://itunes.apple.com/us/album/concert-by-the-sea/id192787263",
    "cover": "http://a4.mzstatic.com/us/r30/Music/38/50/49/mzi.trcydnrm.170x170-75.jpg",
    "color": "#6B548B",
    "text": "#2A231F",
    "musicians": [
     "Denzil Best",
      "Eddie Calhoun",
      "Erroll Garner"
    ]
  },{
    "artist": "Miles Davis",
    "title": "Bitches Brew",
    "itunes": "https://itunes.apple.com/us/album/bitches-brew-legacy-edition/id387785709",
    "cover": "http://a5.mzstatic.com/us/r30/Features/v4/2c/a0/0c/2ca00caf-3889-59a9-c927-86011f9e8aab/dj.ibkxnerg.170x170-75.jpg",
    "color": "#649B9E",
    "text": "#212B30",
    "musicians": [
      "Don Alias",
      "Harvey Brooks",
      "Billy Cobham",
      "Chick Corea",
      "Miles Davis",
      "Jack DeJohnette",
      "Dave Holland",
      "Bennie Maupin",
      "John McLaughlin",
      "Airto Moreira",
      "Juma Santos",
      "Wayne Shorter",
      "Lenny White",
      "Larry Young",
      "Joe Zawinul"
    ]
  },{
    "artist": "Sonny Rollings",
    "title": "Saxophone Colossus",
    "itunes": "https://itunes.apple.com/us/album/saxophone-colossus-reissue/id129952067",
    "cover": "http://a5.mzstatic.com/us/r30/Features/9c/45/92/dj.lhsjunju.170x170-75.jpg",
    "color": "#32ADF1",
    "text": "#0D1D27",
    "musicians": [
      "Tommy Flanagan",
      "Sonny Rollins",
      "Max Roach",
      "Doug Watkins"
    ]
  },{
    "artist": "Art Blakey and The Jazz Messengers",
    "title": "Moanin’",
    "itunes": "https://itunes.apple.com/us/album/moanin-remastered/id725816184",
    "cover": "http://a3.mzstatic.com/us/r30/Music/v4/a4/9e/d9/a49ed936-5c20-2e6b-fbc4-246006bdcbce/00724349532458.170x170-75.jpg",
    "color": "#C3A550",
    "text": "#161A11",
    "musicians": [
      "Art Blakey",
      "Lee Morgan",
      "Benny Golson",
      "Bobby Timmons",
      "Jymie Merritt"
    ]
  },{
    "title": "Clifford Brown and Max Roach",
    "itunes": "https://itunes.apple.com/us/album/clifford-brown-and-max-roach/id539526",
    "cover": "http://a3.mzstatic.com/us/r30/Features/8f/65/0e/dj.wlajviuz.170x170-75.jpg",
    "color": "#DB6C39",
    "text": "#120C19",
    "musicians": [
      "Clifford Brown",
      "Harold Land",
      "George Morrow",
      "Richie Powell",
      "Max Roach"
    ]
  },{
    "artist": "Thelonious Monk Quartet with John Coltrane",
    "title": "At Carnegie Hall",
    "itunes": "https://itunes.apple.com/us/album/at-carnegie-hall/id715742134",
    "cover": "http://a3.mzstatic.com/us/r30/Music/v4/16/97/61/16976189-228e-5fb8-16e3-f2aa8ae09590/00094633517356.170x170-75.jpg",
    "color": "#A2444C",
    "text": "#49637B",
    "musicians": [
      "Ahmed Abdul-Malik",
      "John Coltrane",
      "Thelonious Monk",
      "Shadow Wilson"
    ]
  },{
    "artist": "Hank Mobley",
    "title": "Soul Station",
    "itunes":"https://itunes.apple.com/us/album/soul-station-remastered/id724903486",
    "cover": "http://a3.mzstatic.com/us/r30/Music6/v4/ec/1b/a3/ec1ba39e-d279-8ead-f460-58206f973ebf/00724349534353.170x170-75.jpg",
    "color": "#3D97C5",
    "text": "#152D45",
    "musicians": [
      "Art Blakey",
      "Paul Chambers",
      "Wynton Kelly",
      "Hank Mobley"
    ]
  },{
    "artist": "Cannonball Adderly",
    "title": "Somethin’ Else",
    "itunes": "https://itunes.apple.com/us/album/somethin-else/id721271258",
    "cover": "http://a5.mzstatic.com/us/r30/Music4/v4/2d/aa/d7/2daad774-8979-0bad-01d0-fd40936cded1/05099972196250.170x170-75.jpg",
    "color": "#3C838D",
    "text": "#020C09",
    "musicians": [
      "Cannonball Adderley",
      "Art Blakey",
      "Miles Davis",
      "Hank Jones",
      "Sam Jones"
    ]
  },{
    "artist": "Wayne Shorter",
    "title": "Speak No Evil",
    "itunes": "https://itunes.apple.com/us/album/speak-no-evil/id721228463",
    "cover": "http://a5.mzstatic.com/us/r30/Music4/v4/c6/bd/7f/c6bd7fd6-7693-7dd0-9740-cdb564455673/05099963651157.170x170-75.jpg",
    "color": "#10507E",
    "text": "#06111F",
    "musicians": [
      "Ron Carter",
      "Herbie Hancock",
      "Freddie Hubbard",
      "Elvin Jones",
      "Wayne Shorter"
    ]
  },{
    "artist": "Miles Davis",
    "title": "Birth of the Cool",
    "itunes": "https://itunes.apple.com/nz/album/birth-of-the-cool-remastered/id724552390",
    "cover": "http://a1.mzstatic.com/us/r30/Music/v4/c5/47/19/c5471971-aed3-b477-1340-e246068e2388/00724353011758.170x170-75.jpg",
    "color": "#B23035",
    "text": "#1E1A1E",
    "musicians": [
      "Bill Barber",
      "Nelson Boyd",
      "Kenny Clarke",
      "Junior Collins",
      "Miles Davis",
      "Kenny Hagood",
      "Al Haig",
      "J. J. Johnson",
      "Lee Konitz",
      "John Lewis",
      "Al McKibbon",
      "Gerry Mulligan",
      "Max Roach",
      "Gunther Schuller",
      "Joe Shulman",
      "Sandy Siegelstein",
      "Kai Winding"
    ]
  },{
    "artist": "Herbie Hancock",
    "title": "Maiden Voyage",
    "itunes": "https://itunes.apple.com/us/album/maiden-voyage-remastered/id721271378",
    "cover": "http://a4.mzstatic.com/us/r30/Music/v4/c6/d1/7e/c6d17eaf-9e4c-d4fc-6253-c0f21a202585/05099963651454.170x170-75.jpg",
    "color": "#B4CA68",
    "text": "#0F404D",
    "musicians": [
      "Ron Carter",
      "George Coleman",
      "Herbie Hancock",
      "Freddie Hubbard",
      "Tony Williams"
    ]
  },{
    "artist": "Vince Guaraldi Trio",
    "title": "A Boy Named Charlie Brown",
    "itunes": "https://itunes.apple.com/us/album/a-boy-named-charlie-brown/id139986031",
    "cover": "http://a4.mzstatic.com/us/r30/Features/bc/4e/6c/dj.ajuwwbjm.170x170-75.jpg",
    "color": "#761826",
    "text": "#322431",
    "musicians": [
      "Colin Bailey",
      "Monty Budwig",
      "Vince Guaraldi"
    ]
  },{
    "artist": "Eric Dolphy",
    "title": "Out to Lunch",
    "itunes": "https://itunes.apple.com/us/album/out-to-lunch/id721218360",
    "cover": "http://a2.mzstatic.com/us/r30/Music/v4/b2/84/55/b2845520-816f-4531-2ff9-75faa3f0473c/05099963652253.170x170-75.jpg",
    "color": "#84C2DD",
    "text": "#172F33",
    "musicians": [
      "Richard Davis",
      "Eric Dolphy",
      "Freddie Hubbard",
      "Bobby Hutcherson",
      "Tony Williams"
    ]
  },{
    "artist": "Oliver Nelson",
    "title": "The Blues and the Abstract Truth",
    "itunes": "https://itunes.apple.com/us/album/blues-abstract-truth/id72075",
    "cover": "http://a4.mzstatic.com/us/r30/Features/b6/bc/02/dj.ijqtqnth.170x170-75.jpg",
    "color": "#C56A46",
    "text": "#303969",
    "musicians": [
      "George Barrow",
      "Paul Chambers",
      "Eric Dolphy",
      "Bill Evans",
      "Roy Haynes",
      "Freddie Hubbard",
      "Oliver Nelson"
    ]
  },{
    "artist": "Dexter Gordon",
    "title": "Go",
    "itunes": "https://itunes.apple.com/us/album/go/id721286755",
    "cover": "http://a1.mzstatic.com/us/r30/Music4/v4/ad/42/18/ad4218a3-b877-2eca-c144-51908649b166/05099993409957.170x170-75.jpg",
    "color": "#EF5437",
    "text": "#31474D",
    "musicians": [
      "Sonny Clark",
      "Dexter Gordon",
      "Billy Higgins",
      "Butch Warren"
    ]
  },{
    "title": "Sarah Vaughan with Clifford Brown",
    "itunes": "https://itunes.apple.com/ie/album/sarah-vaughan-clifford-brown/id81905225",
    "cover": "http://a5.mzstatic.com/us/r30/Music/y2004/m06/d08/h09/s06.oyswffkb.170x170-75.jpg",
    "color": "#29AFDD",
    "text": "#203230",
    "musicians": [
      "Joe Benjamin",
      "Clifford Brown",
      "Roy Haynes",
      "Jimmy Jones",
      "John Malachi",
      "Herbie Mann",
      "Paul Quinichette",
      "Sarah Vaughan",
      "Ernie Wilkins"
    ]
  }
];

// Find the graph nodes from the data set. Each
// album is a separate node.

var nodes = data.map(function(entry, idx, list) {

    // This iteration returns a new object for
    // each node.

    var node = {};

    // We retain some of the album's properties.

    node.title    = entry.title;
    node.subtitle = entry.artist;
    node.image    = entry.cover;
    node.url      = entry.itunes;
    node.color    = entry.color;
    node.text     = entry.text;

    // We'll also copy the musicians, again using
    // a more neutral property. At the risk of
    // some confusion, we're going to use the term
    // "link" to refer to an individual connection
    // between nodes, and we'll use the more
    // mathematically correct term "edge" to refer
    // to a line drawn between nodes on the graph.
    // (This may be confusing because D3 refers to
    // the latter as "links."

    node.links = entry.musicians.slice(0);

    // As long as we're iterating through the nodes
    // array, take the opportunity to create an
    // initial position for the nodes. Somewhat
    // arbitrarily, we start the nodes off in a
    // circle in the center of the container.

    var radius = 0.4 * Math.min(height,width);
    var theta = idx*2*Math.PI / list.length;
    node.x = (width/2) + radius*Math.sin(theta);
    node.y = (height/2) + radius*Math.cos(theta);

    // Return the newly created object so it can be
    // added to the nodes array.

    return node;
});

// Identify all the indivual links between nodes on
// the graph. As noted above, we're using the term
// "link" to refer to a single connection. As we'll
// see below, we'll call lines drawn on the graph
// (which may represent a combination of multiple
// links) "edges" in a nod to the more mathematically
// minded.

var links = [];

// Start by iterating through the albums.

data.forEach(function(srcNode, srcIdx, srcList) {

    // For each album, iterate through the musicians.

    srcNode.musicians.forEach(function(srcLink) {

        // For each musican in the "src" album, iterate
        // through the remaining albums in the list.

        for (var tgtIdx = srcIdx + 1;
                 tgtIdx < srcList.length;
                 tgtIdx++) {

            // Use a variable to refer to the "tgt"
            // album for convenience.

            var tgtNode = srcList[tgtIdx];

            // Is there any musician in the "tgt"
            // album that matches the musican we're
            // currently considering from the "src"
            // album?

            if (tgtNode.musicians.some(function(tgtLink){
                return tgtLink === srcLink;
            })) {

                // When we do find a match, add a new
                // link to the links array.

                links.push({
                    source: srcIdx,
                    target: tgtIdx,
                    link: srcLink
                });
            }
        }
    });
});

// Now create the edges for our graph. We do that by
// eliminating duplicates from the links array.

var edges = [];

// Iterate through the links array.

links.forEach(function(link) {

    // Assume for now that the current link is
    // unique.

    var existingEdge = false;

    // Look through the edges we've collected so
    // far to see if the current link is already
    // present.

    for (var idx = 0; idx < edges.length; idx++) {

        // A duplicate link has the same source
        // and target values.

        if ((link.source === edges[idx].source) &&
            (link.target === edges[idx].target)) {

            // When we find an existing link, remember
            // it.
            existingEdge = edges[idx];

            // And stop looking.

            break;
        }
    }

    // If we found an existing edge, all we need
    // to do is add the current link to it.

    if (existingEdge) {

        existingEdge.links.push(link.link);

    } else {

        // If there was no existing edge, we can
        // create one now.

        edges.push({
            source: link.source,
            target: link.target,
            links: [link.link]
        });
    }
});

// Start the creation of the graph by adding the edges.
// We add these first so they'll appear "underneath"
// the nodes.

var edgeSelection = svg.selectAll('.edge')
    .data(edges)
    .enter()
    .append('line')
    .classed('edge', true)
    .style('stroke', edgeStroke)
    .call(positionEdge, nodes);

// Next up are the nodes.

var nodeSelection = svg.selectAll('.node')
    .data(nodes)
    .enter()
    .append('g')
    .classed('node', true)
    .call(positionNode);

nodeSelection.append('circle')
    .attr('r', nodeRadius)
    .attr('data-node-index', function(d,i) { return i;})
    .style('fill', nodeFill)

// Now that we have our main selections (edges and
// nodes), we can create some subsets of those
// selections that will be helpful. Those subsets
// will be tied to individual nodes, so we'll
// start by iterating through them. We do that
// in two separate passes.

nodeSelection.each(function(node){

    // First let's identify all edges that are
    // incident to the node. We collect those as
    // a D3 selection so we can manipulate the
    // set easily with D3 utilities.

    node.incidentEdgeSelection = edgeSelection
        .filter(function(edge) {
            return nodes[edge.source] === node ||
                   nodes[edge.target] === node;
        });
});

// Now make a second pass through the nodes.

nodeSelection.each(function(node){

    // For this pass we want to find all adjacencies.
    // An adjacent node shares an edge with the
    // current node.

    node.adjacentNodeSelection = nodeSelection
        .filter(function(otherNode){

            // Presume that the nodes are not adjacent.
            var isAdjacent = false;

            // We can't be adjacent to ourselves.

            if (otherNode !== node) {

                // Look the incident edges of both nodes to
                // see if there are any in common.

                node.incidentEdgeSelection.each(function(edge){
                    otherNode.incidentEdgeSelection.each(function(otherEdge){
                        if (edge === otherEdge) {
                            isAdjacent = true;
                        }
                    });
                });

            }

            return isAdjacent;
        });

});

// Next we create a array for the node labels.
// We're going to use a "hidden" force layout to
// position the labels so they don't overlap
// each other. ("Hidden" because the links won't
// be visible.)

var labels = [];
var labelLinks = [];

nodes.forEach(function(node, idx){

    // For each node on the graph we create
    // two pseudo-nodes for its label. Once
    // pseudo-node will be anchored to the
    // center of the real node, while the
    // second will be linked to that node.

    // Add the pseudo-nodes to their array.

    labels.push({node: node});
    labels.push({node: node});

    // And create a link between them.

    labelLinks.push({
        source: idx * 2,
        target: idx * 2 + 1
    });
});

// Construct the selections for the label layout.

// There's no need to add any markup for the
// pseudo-links between the label nodes, but
// we do need a selection so we can run the
// force layout.

var labelLinkSelection = svg.selectAll('line.labelLink')
    .data(labelLinks);

// The label pseud-nodes themselves are just
// `<g>` containers.

var labelSelection = svg.selectAll('g.labelNode')
    .data(labels)
    .enter()
    .append('g')
        .classed('labelNode',true);

// Now add the text itself. Of the paired
// pseudo-nodes, only odd ones get the text
// elements.

labelSelection.append('text')
    .text(function(d, i) {
        return i % 2 == 0 ? '' : d.node.title;
    })
    .attr('data-node-index', function(d, i){
        return i % 2 == 0 ? 'none' : Math.floor(i/2);
    });

// The last bit of markup are the lists of
// connections for each link.

var connectionSelection = graph.selectAll('ul.connection')
    .data(edges)
    .enter()
    .append('ul')
    .classed('connection hidden', true)
    .attr('data-edge-index', function(d,i) {return i;});

connectionSelection.each(function(connection){
    var selection = d3.select(this);
    connection.links.forEach(function(link){
        selection.append('li')
            .text(link);
    })
})

// Create the main force layout.

var force = d3.layout.force()
    .size([width, height])
    .nodes(nodes)
    .links(edges)
    .linkDistance(linkDistance)
    .charge(-500);

// Create the force layout for the labels.

var labelForce = d3.layout.force()
    .size([width, height])
    .nodes(labels)
    .links(labelLinks)
    .gravity(0)
    .linkDistance(0)
    .linkStrength(0.8)
    .charge(-100);

// Let users drag the nodes.

nodeSelection.call(force.drag);

// Function to handle clicks on node elements

var nodeClicked = function(node) {

    // Ignore events based on dragging.

    if (d3.event.defaultPrevented) return;

    // Remember whether or not the clicked
    // node is currently selected.

    var selected = node.selected;

    // Keep track of the desired text color.

    var fillColor;

    // In all cases we start by resetting
    // all the nodes and edges to their
    // de-selected state. We may override
    // this transition for some nodes and
    // edges later.

    nodeSelection
        .each(function(node) { node.selected = false; })
        .selectAll('circle')
            .transition()
            .attr('r', nodeRadius)
            .style('fill', nodeFill);

    edgeSelection
        .transition()
        .style('stroke', edgeStroke);

    labelSelection
        .transition()
        .style('opacity', 0);

    // Now see if the node wasn't previously selected.

    if (!selected) {

        // This node wasn't selected before, so
        // we want to select it now. That means
        // changing the styles of some of the
        // elements in the graph.

        // First we transition the incident edges.

        node.incidentEdgeSelection
            .transition()
            .style('stroke', node.color);

        // Now we transition the adjacent nodes.

        node.adjacentNodeSelection.selectAll('circle')
            .transition()
            .attr('r', nodeRadius)
            .style('fill', node.color);

        labelSelection
            .filter(function(label) {
                var adjacent = false;
                node.adjacentNodeSelection.each(function(d){
                    if (label.node === d) {
                        adjacent = true;
                    }
                })
                return adjacent;
            })
            .transition()
            .style('opacity', 1)
            .selectAll('text')
                .style('fill', adjLabelFill);

        // And finally, transition the node itself.

        d3.selectAll('circle[data-node-index="'+node.index+'"]')
            .transition()
            .attr('r', selectedNodeRadius)
            .style('fill', node.color);

        // Make sure the node's label is visible

        labelSelection
            .filter(function(label) {return label.node === node;})
            .transition()
            .style('opacity', 1);

        // And note the desired color for bundling with
        // the transition of the label position.

        fillColor = node.text;

        // Delete the current notes section to prepare
        // for new information.

        notes.selectAll('*').remove();

        // Fill in the notes section with informationm
        // from the node. Because we want to transition
        // this to match the transitions on the graph,
        // we first set it's opacity to 0.

        notes.style({'opacity': 0});

        // Now add the notes content.

        notes.append('h1').text(node.title);
        notes.append('h2').text(node.subtitle);
        if (node.url && node.image) {
            notes.append('div')
                .classed('artwork',true)
                .append('a')
                .attr('href', node.url)
                .append('img')
                    .attr('src', node.image);
        }
        var list = notes.append('ul');
        node.links.forEach(function(link){
            list.append('li')
                .text(link);
        })

        // With the content in place, transition
        // the opacity to make it visible.

        notes.transition().style({'opacity': 1});

    } else {

        // Since we're de-selecting the current
        // node, transition the notes section
        // and then remove it.

        notes.transition()
            .style({'opacity': 0})
            .each('end', function(){
                notes.selectAll('*').remove();
            });

        // Transition all the labels to their
        // default styles.

        labelSelection
            .transition()
            .style('opacity', 1)
            .selectAll('text')
                .style('fill', labelFill);

        // The fill color for the current node's
        // label must also be bundled with its
        // position transition.

        fillColor = labelFill;
    }

    // Toggle the selection state for the node.

    node.selected = !selected;

    // Update the position of the label text.

    var text = d3.select('text[data-node-index="'+node.index+'"]').node();
    var label = null;
    labelSelection.each(function(d){
        if (d.node === node) { label = d; }
    })

    if (text && label) {
        positionLabelText(text, label, fillColor);
    }

};

// Function to handle click on edges.

var edgeClicked = function(edge, idx) {

    // Remember the current selection state of the edge.

    var selected = edge.selected;

    // Transition all connections to hidden. If the
    // current edge needs to be displayed, it's transition
    // will be overridden shortly.

    connectionSelection
        .each(function(edge) { edge.selected = false; })
        .transition()
        .style('opacity', 0)
        .each('end', function(){
            d3.select(this).classed('hidden', true);
        });

    // If the current edge wasn't selected before, we
    // want to transition it to the selected state now.

    if (!selected) {
        d3.select('ul.connection[data-edge-index="'+idx+'"]')
            .classed('hidden', false)
            .style('opacity', 0)
            .transition()
            .style('opacity', 1);
    }

    // Toggle the resulting selection state for the edge.

    edge.selected = !selected;

};

// Handle clicks on the nodes.

nodeSelection.on('click', nodeClicked);

labelSelection.on('click', function(pseudonode) {
    nodeClicked(pseudonode.node);
});

// Handle clicks on the edges.

edgeSelection.on('click', edgeClicked);
connectionSelection.on('click', edgeClicked);

// Animate the force layout.

force.on('tick', function() {

    // Constrain all the nodes to remain in the
    // graph container.

    nodeSelection.each(function(node) {
        node.x = Math.max(node.x, 2*selectedNodeRadius);
        node.y = Math.max(node.y, 2*selectedNodeRadius);
        node.x = Math.min(node.x, width-2*selectedNodeRadius);
        node.y = Math.min(node.y, height-2*selectedNodeRadius);
    });

    // Kick the label layout to make sure it doesn't
    // finish while the main layout is still running.

    labelForce.start();

    // Calculate the positions of the label nodes.

    labelSelection.each(function(label, idx) {

        // Label pseudo-nodes come in pairs. We
        // treat odd and even nodes differently.

        if(idx % 2) {

            // Odd pseudo-nodes have the actual text.
            // That text needs a real position. The
            // pseudo-node itself we leave to the
            // force layout to position.

            positionLabelText(this.childNodes[0], label);

        } else {

            // Even pseudo-nodes (which have no text)
            // are fixed to the center of the
            // corresponding real node. This will
            // override the position calculated by
            // the force layout.

            label.x = label.node.x;
            label.y = label.node.y;

        }
    });

    // Calculate the position for the connection lists.

    connectionSelection.each(function(connection){
        var x = (connection.source.x + connection.target.x)/2 - 27;
        var y = (connection.source.y + connection.target.y)/2;
        d3.select(this)
            .style({
                'top':  y + 'px',
                'left': x + 'px'
            });
    });

    // Update the posistions of the nodes and edges.

    nodeSelection.call(positionNode);
    labelSelection.call(positionNode);
    edgeSelection.call(positionEdge);
    labelLinkSelection.call(positionEdge);

});

// Start the layout computations.
force.start();
labelForce.start();


    </script>
</body>
</html>


