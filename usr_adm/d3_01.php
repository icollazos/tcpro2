¡Claro! Aquí tienes un ejemplo básico y funcional de una página HTML con un gráfico de barras simple creado con D3.js:
HTML

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Gráfico de Barras con D3.js</title>
</head>
<body>
  <div id="chart"></div>

  <script src="https://d3js.org/d3.v7.min.js"></script>
  <script>
    // Datos de ejemplo
    const data = [12, 5, 20, 18, 9];

    // Dimensiones del gráfico
    const width = 400;
    const height = 300;
    const margin = { top: 20, right: 30, bottom: 30, left: 40 };

    // Crear un elemento SVG
    const svg = d3.select("#chart")
      .append("svg")
      .attr("width", width)
      .attr("height", height);

    // Crear una escala para los datos
    const x = d3.scaleBand()
      .domain(data.map((d, i) => i))
      .range([margin.left, width - margin.right])
      .padding(0.1);

    const y = d3.scaleLinear()
      .domain([0, d3.max(data)])  


      .range([height - margin.bottom, margin.top]);  


    // Agregar las barras al gráfico
    svg.selectAll("rect")
      .data(data)
      .enter()
      .append("rect")
      .attr("x", (d, i) => x(i))
      .attr("y", d => y(d))
      .attr("width", x.bandwidth())
      .attr("height", d => height - margin.bottom - y(d))
      .attr("fill", "steelblue");

    // Agregar un eje X
    svg.append("g")
      .attr("transform", `translate(0,${height - margin.bottom})`)
      .call(d3.axisBottom(x));

    // Agregar un eje Y
    svg.append("g")
      .attr("transform", `translate(${margin.left},0)`)
      .call(d3.axisLeft(y));
  </script>
</body>
</html>