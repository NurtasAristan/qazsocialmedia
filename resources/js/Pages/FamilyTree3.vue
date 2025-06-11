

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import f3 from 'family-chart';  // npm install family-chart@0.5.1 or yarn add family-chart@0.5.1
import 'family-chart/styles/family-chart.css';
     
export default {
  name: "FamilyChart",
  components: {
    AppLayout,
  },
  mounted() {
    
    create(data())

    function create(data) {
      const f3Chart = f3.createChart('#FamilyChart', data)
        .setTransitionTime(1000)
        .setCardXSpacing(250)
        .setCardYSpacing(150)
        .setSingleParentEmptyCard(true, {label: 'ADD'})
        .setShowSiblingsOfMain(false)
        .setOrientationVertical()
    
      const f3Card = f3Chart.setCard(f3.CardHtml)
        .setCardDisplay([["first name"],[]])
        .setCardDim({})
        .setMiniTree(true)
        .setStyle('imageRect')
        .setOnHoverPathToMain()
    
      
      const f3EditTree = f3Chart.editTree()
        .fixed(true)
        .setFields(["first name"])
        .setEditFirst(true)
      
      f3EditTree.setEdit()
      
      f3Card.setOnCardClick((e, d) => {
        f3EditTree.open(d)
        if (f3EditTree.isAddingRelative()) return
        f3Card.onCardClickDefault(e, d)
      })
    
      f3Chart.updateTree({initial: true})
      f3EditTree.open(f3Chart.getMainDatum())
    
      f3Chart.updateTree({initial: true})
    }
    
    function data() {
      return [
        {
          "id": "0",
          "rels": {
            "spouses": [],
            "children": []
          },
          "data": {
            "first name": "Name",
            "last name": "Surname",
            "birthday": 1970,
            "avatar": "https://static8.depositphotos.com/1009634/988/v/950/depositphotos_9883921-stock-illustration-no-user-profile-picture.jpg",
            "gender": "M"
          }
        }
      ]
    }

  },
};
</script>

<template>
    <AppLayout title="Family Tree">
        <div id="FamilyChart" class="f3" style="width:100%;height:900px;margin:auto;background-color:rgb(33,33,33);color:#fff;"></div>
    </AppLayout>
</template>