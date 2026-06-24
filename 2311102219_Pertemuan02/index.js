const express = require("express")
const sqlite3 = require("sqlite3").verbose()
const bodyParser = require("body-parser")
const path = require("path")

const app = express()
const PORT = 3000

app.use(bodyParser.json())
app.use(express.static(path.join(__dirname, "public")))

const db = new sqlite3.Database("pengeluaran.db")

db.run(`CREATE TABLE IF NOT EXISTS transaksi(
id INTEGER PRIMARY KEY AUTOINCREMENT,
tanggal TEXT,
keterangan TEXT,
jenis TEXT,
jumlah INTEGER
)`)

// READ
app.get("/api/transaksi", (req, res) => {
    db.all("SELECT * FROM transaksi", (err, rows) => {
        if (err) return res.status(500).json(err)
        res.json(rows)
    })
})

// CREATE
app.post("/api/transaksi", (req, res) => {
    const { tanggal, keterangan, jenis, jumlah } = req.body
    db.run(
        "INSERT INTO transaksi(tanggal,keterangan,jenis,jumlah) VALUES (?,?,?,?)",
        [tanggal, keterangan, jenis, jumlah],
        err => err ? res.status(500).json(err) : res.json({ message: "Data berhasil ditambahkan" })
    )
})

// DELETE
app.delete("/api/transaksi/:id", (req, res) => {
    db.run("DELETE FROM transaksi WHERE id=?", [req.params.id],
        err => err ? res.status(500).json(err) : res.json({ message: "Data berhasil dihapus" })
    )
})
// =====================
// UPDATE
// =====================
app.put("/api/transaksi/:id", (req, res) => {

    const id = req.params.id
    const { tanggal, keterangan, jenis, jumlah } = req.body

    db.run(
        "UPDATE transaksi SET tanggal=?, keterangan=?, jenis=?, jumlah=? WHERE id=?",
        [tanggal, keterangan, jenis, jumlah, id],
        function (err) {

            if (err) {
                res.status(500).json(err)
                return
            }

            res.json({ message: "Data berhasil diupdate" })

        })

})

app.listen(PORT, () => console.log(`Server berjalan di http://localhost:${PORT}`))