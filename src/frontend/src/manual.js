export const exportToPDF = (data1, data2) => {
	import("https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js")
		.then(() => {
			var wrapper = document.createElement("div");
			wrapper.appendChild(data1.cloneNode(true));
			wrapper.appendChild(data2.cloneNode(true));
			var opt = {
				margin: 1,
				filename: "manual.pdf",
				image: { type: "pdf", quality: 0.98 },
				jsPDF: { unit: "cm", format: "letter", orientation: "portrait" },
			};
			html2pdf().from(wrapper).set(opt).save();
		})
		.catch(error => {
			console.error("Error loading html2pdf.js:", error);
		});
};
