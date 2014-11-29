var pdfReceipt;

function createPDF(){

   pdfReceipt = {
      pageSize: 'A4',

      pageMargins: [ 40, 40, 40, 40 ],

      content: [
       {  text: 'UNTVote - Confirmation receipt for ' + $('#btnDownloadReceipt').data('user') + '\n\n',
          style: 'header',
          fontSize: 18
       },

       {
		  text: [
            { text: 'Election: ', bold: true },
            { text: $('#btnDownloadReceipt').data('election') + '\n\n'}
          ]
       },

       {
		  text: [
            { text: 'Voted for: ', bold: true },
            { text: $('#btnDownloadReceipt').data('candidate') + '\n\n'}
          ]
       },

      {
        text: [
          { text: 'Voted date: ', bold: true },
          { text: $('#btnDownloadReceipt').data('date') + '\n\n'}
        ]
      },

       {
		  text: [
            { text: 'Confirmation#: ', bold: true },
            { text: $('#btnDownloadReceipt').data('confirmation') + '\n\n'}
          ]
       }

     ],

     styles: {
       header: {
         fontSize: 22,
         bold: true
       },
     }
 };

}

$(document).ready(function(){

  $('#btnDownloadReceipt').on('click', function() {
    createPDF();
    pdfMake.createPdf(pdfReceipt).download("UNTVote-Confirmation-Receipt.pdf");
  });

});