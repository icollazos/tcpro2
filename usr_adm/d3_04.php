<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Le Miserable Force Directed Graph</title>
    <meta name="description" content="force directed graph example" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="d3.min.js"></script>
    <link href="style_d3.css" rel="stylesheet" />
    <style>
      circle {
        stroke: #fff;
        stroke-width: 1;
      }

      .link {
        stroke: #999;
        stroke-opacity: 0.6;
      }
    </style>
  </head>

  <body>
    <h1>Force Layout</h1>
    <div id="grafico"></div>

    <script>
      // Original demo from Mike Bostock: http://bl.ocks.org/mbostock/ad70335eeef6d167bc36fd3c04378048

      var fuente="miserables_txt.json";
      var fuente="miserables_id.json";

      const margin = {
        top: 40,
        bottom: 10,
        left: 20,
        right: 20,
      };
      const width = 800 - margin.left - margin.right;
      const height = 600 - margin.top - margin.bottom;

      // Creates sources <svg> element and inner g (for margins)
      const svg = d3
        .select("#grafico")
        .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", `translate(${margin.left}, ${margin.top})`);

      /////////////////////////

      const simulation = d3
        .forceSimulation()
        .force(
          "link",
          d3.forceLink().id((d) => d.id)
        )
        .force("charge", d3.forceManyBody())
        .force("center", d3.forceCenter(width / 2, height / 2));

      const color = d3.scaleOrdinal(d3.schemeCategory10);

	d3.json(fuente).then((data) => {
      	l(data);
        // Links data join
        const link = svg
          .selectAll(".link")
          .data(data.links)
          .join((enter) => enter.append("line").attr("class", "link"));

        // Nodes data join
        const node = svg
          .selectAll(".node")
          .data(data.nodes)
          .join((enter) => {
            const node_enter = enter.append("circle").attr("class", "node").attr("r", 10);
            node_enter.append("title").text((d) => d.nodeName);
            return node_enter;
          });

node.call(d3.drag()
        .on("start", dragstarted)
        .on("drag", dragged)
        .on("end", dragended));
        node.style("fill", (d) => color(d.group));

        simulation.nodes(data.nodes).force("link").links(data.links);

        simulation.on("tick", (e) => {
          link
            .attr("x1", (d) => d.source.x)
            .attr("y1", (d) => d.source.y)
            .attr("x2", (d) => d.target.x)
            .attr("y2", (d) => d.target.y);

          node.attr("cx", (d) => d.x).attr("cy", (d) => d.y);
        });
        /**/
      });




    function dragstarted(event) {
    if (!event.active) simulation.alphaTarget(0.3).restart();
    event.subject.fx = event.subject.x;
    event.subject.fy = event.subject.y;
  }

  // Update the subject (dragged node) position during drag.
  function dragged(event) {
    event.subject.fx = event.x;
    event.subject.fy = event.y;
  }

  // Restore the target alpha so the simulation cools after dragging ends.
  // Unfix the subject position now that it’s no longer being dragged.
  function dragended(event) {
    if (!event.active) simulation.alphaTarget(0);
    event.subject.fx = null;
    event.subject.fy = null;
  }

      function l(x){
      	console.log(x);
      }
    </script>
  </body>
</html>