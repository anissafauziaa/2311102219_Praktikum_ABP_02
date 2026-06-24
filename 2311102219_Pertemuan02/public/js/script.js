$(document).ready(function () {

    $("#formTransaksi").submit(function (e) {

        e.preventDefault()

        const data = {
            tanggal: $("#tanggal").val(),
            keterangan: $("#keterangan").val(),
            jenis: $("#jenis").val(),
            jumlah: $("#jumlah").val()
        }

        $.ajax({
            url: "/api/transaksi",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function (res) {

                alert("Data berhasil disimpan")

                $("#formTransaksi")[0].reset()

            }
        })

    })

})