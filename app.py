from flask import Flask, render_template

app = Flask(__name__)

@app.route("/")
def about():
    return render_template("about.html", title="About - Sahil")

@app.route("/resume")
def resume():
    return render_template("resume.html", title="Resume - Sahil")

@app.route("/projects")
def projects():
    return render_template("projects.html", title="Projects - Sahil")

@app.route("/certificates")
def certificates():
    return render_template("certificates.html", title="Certificates - Sahil")

@app.route("/contact")
def contact():
    return render_template("contact.html", title="Contact - Sahil")

if __name__ == "__main__":
    app.run(debug=True)
