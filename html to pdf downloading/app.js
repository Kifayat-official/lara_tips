const express = require('express');
const puppeteer = require('puppeteer');

const app = express();
const port = 3000;

app.get('/generate-pdf', async (req, res) => {
  const url = req.query.url;

  try {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();

    // Configure the page
    await page.setViewport({ width: 1920, height: 1080 });
    await page.goto(url, { waitUntil: 'networkidle0' });


    // Generate PDF with fit to page width
    const pdf = await page.pdf({
      format: 'A4',
      scale: 0.7
    });

    await browser.close();

    res.setHeader('Content-Type', 'application/pdf');
    res.setHeader('Content-Disposition', 'attachment; filename="page.pdf"');
    res.send(pdf);
  } catch (error) {
    console.error('Error generating PDF:', error);
    res.status(500).send('Error generating PDF');
  }
});

app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
