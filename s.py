import streamlit as st

# Sidebar content
st.sidebar.image("assets/images/1712336716301.jpg", width=80)
st.sidebar.title("Sahil Karande")
st.sidebar.write("IIOT Intern at Solar Industries")
st.sidebar.write("Data Science Aspirant")

# Show Contacts button
show_contacts = st.sidebar.button("Show Contacts")

if show_contacts:
    st.sidebar.write("---")  # Separator line
    st.sidebar.subheader("Contacts")

    # Contacts details
    st.sidebar.markdown("""- **Email:** [skarande220@gmail.com](mailto:skarande220@gmail.com)
                        - **Phone:** [+91 9881678709](tel:+919881678709)
                        - **Birthday:** November 22, 2001
                        - **Location:** Nagpur, Maharashtra, India""")

    st.sidebar.write("---")  # Separator line
    st.sidebar.subheader("Social Links")

    # Social links
    st.sidebar.markdown("""- [Twitter](https://twitter.com/Sahilkarande9)
                        - [Instagram](https://www.instagram.com/escaee/)
                        - [LinkedIn](https://www.linkedin.com/in/sahil-karande-a77aa7207/)
                        - [GitHub](https://github.com/sahilkarande)
                        - [WhatsApp](https://wa.me/+919881678709)""")

    st.sidebar.write("---")  # Separator line
